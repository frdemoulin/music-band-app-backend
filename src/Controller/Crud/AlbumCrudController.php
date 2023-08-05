<?php

namespace App\Controller\Crud;

use App\Entity\Album;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class AlbumCrudController extends AbstractCrudController
{
    public function __construct(private TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public static function getEntityFqcn(): string
    {
        return Album::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ->setEntityLabelInPlural(function (?Album $album, ?string $pageName) {
            //     if (Crud::PAGE_INDEX === $pageName) {
            //         return ucfirst($this->translator->trans('album.index.label'));
            //     } elseif ('detail' === $pageName) {
            //         return ucfirst($this->translator->trans('album.detail.label'));
            //     } elseif (Crud::PAGE_NEW === $pageName) {
            //         return ucfirst($this->translator->trans('album.new.label'));
            //     } elseif ('edit' === $pageName) {
            //         return ucfirst($this->translator->trans('album.edit.label'));
            //     }
            // })
            ->setPageTitle(Crud::PAGE_INDEX, ucfirst($this->translator->trans('album.index.page.title')))
            ->setPageTitle(Crud::PAGE_DETAIL, ucfirst($this->translator->trans('album.detail.page.title')))
            ->setPageTitle(Crud::PAGE_NEW, ucfirst($this->translator->trans('album.new.page.title')))
            ->setPageTitle(Crud::PAGE_EDIT, ucfirst($this->translator->trans('album.edit.page.title')))
            ->setDateFormat('d/m/Y')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action
                    ->setLabel(ucfirst($this->translator->trans('album.new.action.label')))
            )
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', ucfirst($this->translator->trans('title'))),
            IntegerField::new('releasedYear', ucfirst($this->translator->trans('releasedYear'))),
            ChoiceField::new('albumSort', ucfirst($this->translator->trans('type'))),
        ];
    }
}
