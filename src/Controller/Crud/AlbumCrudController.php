<?php

namespace App\Controller\Crud;

use App\Entity\Album;
use App\Service\GenericHelper;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
            //         return GenericHelper::mb_ucfirst($this->translator->trans('album.index.label'));
            //     } elseif ('detail' === $pageName) {
            //         return GenericHelper::mb_ucfirst($this->translator->trans('album.detail.label'));
            //     } elseif (Crud::PAGE_NEW === $pageName) {
            //         return GenericHelper::mb_ucfirst($this->translator->trans('album.new.label'));
            //     } elseif ('edit' === $pageName) {
            //         return GenericHelper::mb_ucfirst($this->translator->trans('album.edit.label'));
            //     }
            // })
            ->setPageTitle(Crud::PAGE_INDEX, GenericHelper::mb_ucfirst($this->translator->trans('album.index.page.title')))
            ->setPageTitle(Crud::PAGE_DETAIL, GenericHelper::mb_ucfirst($this->translator->trans('album.detail.page.title')))
            ->setPageTitle(Crud::PAGE_NEW, GenericHelper::mb_ucfirst($this->translator->trans('album.new.page.title')))
            ->setPageTitle(Crud::PAGE_EDIT, GenericHelper::mb_ucfirst($this->translator->trans('album.edit.page.title')))
            ->setDateFormat('d/m/Y')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action
                    ->setLabel(GenericHelper::mb_ucfirst($this->translator->trans('album.new.action.label')))
            )
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title', GenericHelper::mb_ucfirst($this->translator->trans('title'))),
            IntegerField::new('releasedYear', GenericHelper::mb_ucfirst($this->translator->trans('released.year'))),
            AssociationField::new('albumSort', GenericHelper::mb_ucfirst($this->translator->trans('type')))->renderAsNativeWidget(),
            DateTimeField::new('createdAt', GenericHelper::mb_ucfirst($this->translator->trans('created.at')))->hideOnForm(),
            DateTimeField::new('updatedAt', GenericHelper::mb_ucfirst($this->translator->trans('updated.at')))->hideOnForm(),
        ];
    }
}
