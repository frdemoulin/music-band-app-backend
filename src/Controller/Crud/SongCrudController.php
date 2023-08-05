<?php

namespace App\Controller\Crud;

use App\Entity\Song;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Contracts\Translation\TranslatorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class SongCrudController extends AbstractCrudController
{
    public function __construct(private TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    
    public static function getEntityFqcn(): string
    {
        return Song::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // ->setEntityLabelInPlural(function (?Song $song, ?string $pageName) {
            //     if (Crud::PAGE_INDEX === $pageName) {
            //         return ucfirst($this->translator->trans('song.index.page.title'));
            //     } elseif (Crud::PAGE_DETAIL === $pageName) {
            //         return ucfirst($this->translator->trans('song.detail.page.title'));
            //     } elseif (Crud::PAGE_NEW === $pageName) {
            //         return ucfirst($this->translator->trans('song.new.page.title'));
            //     } elseif (Crud::PAGE_EDIT === $pageName) {
            //         return ucfirst($this->translator->trans('song.edit.page.title'));
            //     }
            // })
            ->setPageTitle(Crud::PAGE_INDEX, ucfirst($this->translator->trans('song.index.page.title')))
            ->setPageTitle(Crud::PAGE_DETAIL, ucfirst($this->translator->trans('song.detail.page.title')))
            ->setPageTitle(Crud::PAGE_NEW, ucfirst($this->translator->trans('song.new.page.title')))
            ->setPageTitle(Crud::PAGE_EDIT, ucfirst($this->translator->trans('song.edit.page.title')))
            ->setDateFormat('d/m/Y')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action
                    ->setLabel(ucfirst($this->translator->trans('song.new.action.label')))
            )
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('shortTitle'),
            IntegerField::new('duration'),
            ChoiceField::new('tuning'),
            ChoiceField::new('album')
        ];
    }
}
