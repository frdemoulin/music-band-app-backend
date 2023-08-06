<?php

namespace App\Controller\Crud;

use App\Entity\Tuning;
use App\Service\GenericHelper;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TuningCrudController extends AbstractCrudController
{
    public function __construct(private TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public static function getEntityFqcn(): string
    {
        return Tuning::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, GenericHelper::mb_ucfirst($this->translator->trans('tuning.index.page.title')))
            ->setPageTitle(Crud::PAGE_DETAIL, GenericHelper::mb_ucfirst($this->translator->trans('tuning.detail.page.title')))
            ->setPageTitle(Crud::PAGE_NEW, GenericHelper::mb_ucfirst($this->translator->trans('tuning.new.page.title')))
            ->setPageTitle(Crud::PAGE_EDIT, GenericHelper::mb_ucfirst($this->translator->trans('tuning.edit.page.title')))
            ->setDateFormat('d/m/Y');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(
                Crud::PAGE_INDEX,
                Action::NEW,
                fn (Action $action) => $action
                    ->setLabel(GenericHelper::mb_ucfirst($this->translator->trans('tuning.new.action.label')))
            );
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('description'),
            DateTimeField::new('createdAt', GenericHelper::mb_ucfirst($this->translator->trans('created.at')))->hideOnForm(),
            DateTimeField::new('updatedAt', GenericHelper::mb_ucfirst($this->translator->trans('updated.at')))->hideOnForm(),
        ];
    }
}
