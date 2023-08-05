<?php

namespace App\Controller\Crud;

use App\Entity\AlbumSort;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AlbumSortCrudController extends AbstractCrudController
{
    public function __construct(private TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    
    public static function getEntityFqcn(): string
    {
        return AlbumSort::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, ucfirst($this->translator->trans('album.type.index.page.title')))
            ->setPageTitle(Crud::PAGE_DETAIL, ucfirst($this->translator->trans('album.type.detail.page.title')))
            ->setPageTitle(Crud::PAGE_NEW, ucfirst($this->translator->trans('album.type.new.page.title')))
            ->setPageTitle(Crud::PAGE_EDIT, ucfirst($this->translator->trans('album.type.edit.page.title')))
            ->setDateFormat('d/m/Y')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action
                    ->setLabel(ucfirst($this->translator->trans('album.type.new.action.label')))
            )
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', ucfirst($this->translator->trans('name'))),
        ];
    }
}
