<?php

namespace App\Controller\Crud;

use App\Entity\LogUser;
use App\Service\GenericHelper;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Contracts\Translation\TranslatorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LogUserCrudController extends AbstractCrudController
{
    public function __construct(private TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    
    public static function getEntityFqcn(): string
    {
        return LogUser::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, GenericHelper::mb_ucfirst($this->translator->trans('connection.log.index.page.title')))
            ->setDateFormat('d/m/Y')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user', GenericHelper::mb_ucfirst($this->translator->trans('user')))->hideOnForm(),
            DateTimeField::new('loginAt', GenericHelper::mb_ucfirst($this->translator->trans('login.at')))->hideOnForm(),
            DateTimeField::new('logoutAt', GenericHelper::mb_ucfirst($this->translator->trans('logout.at')))->hideOnForm(),
            DateTimeField::new('createdAt', GenericHelper::mb_ucfirst($this->translator->trans('created.at')))->hideOnForm(),
            DateTimeField::new('updatedAt', GenericHelper::mb_ucfirst($this->translator->trans('updated.at')))->hideOnForm(),
        ];
    }
}
