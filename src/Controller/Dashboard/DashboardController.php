<?php

namespace App\Controller\Dashboard;

use App\Entity\Song;
use App\Entity\Album;
use App\Entity\Speech;
use App\Entity\Tuning;
use App\Entity\LogUser;
use App\Entity\AlbumSort;
use App\Service\GenericHelper;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Contracts\Translation\TranslatorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', []);
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('admin')
        ;
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            // bouton de création depuis la page PAGE_INDEX
            ->update(Crud::PAGE_INDEX, Action::NEW,
                fn (Action $action) => $action
                    ->setIcon('fa-solid fa-circle-plus')
                    ->setCssClass('btn btn-success')
            )
            // bouton de création depuis la page PAGE_NEW
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN,
                fn (Action $action) => $action
                    ->setCssClass('btn btn-success')
            )
            // bouton de sauvegarde des modifications depuis la page PAGE_EDIT
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN,
                fn (Action $action) => $action
                    ->setCssClass('btn btn-warning')
            )
        ;
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateTimeFormat('medium', 'short');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle(GenericHelper::mb_ucfirst($this->translator->trans('backend.dashboard.title')))
            ->setFaviconPath('favicon.svg')
            ;
    }

    public function configureMenuItems(): iterable
    {
        // Accueil
        yield MenuItem::linkToDashboard(GenericHelper::mb_ucfirst($this->translator->trans('home')), 'fa fa-home');
        // Discographie
        yield MenuItem::section($this->translator->trans('discography'));
        yield MenuItem::linkToCrud(GenericHelper::mb_ucfirst($this->translator->trans('albums')), 'fa-solid fa-compact-disc', Album::class);
        yield MenuItem::linkToCrud(GenericHelper::mb_ucfirst($this->translator->trans('songs')), 'fa-solid fa-music', Song::class);
        yield MenuItem::linkToCrud(GenericHelper::mb_ucfirst($this->translator->trans('albums.type')), 'fa-solid fa-sliders', AlbumSort::class);
        // Paramétrage
        yield MenuItem::section($this->translator->trans('configuration'));
        yield MenuItem::linkToCrud(GenericHelper::mb_ucfirst($this->translator->trans('tunings')), 'fa-solid fa-bars-progress', Tuning::class);
        // Setlists
        yield MenuItem::section($this->translator->trans('setlist'));
        yield MenuItem::linkToCrud(GenericHelper::mb_ucfirst($this->translator->trans('speeches')), 'fa-regular fa-comment', Speech::class);
        // Utilisateurs
        yield MenuItem::section($this->translator->trans('users'));
        yield MenuItem::linkToCrud(GenericHelper::mb_ucfirst($this->translator->trans('connection.log')), 'fa-solid fa-right-to-bracket', LogUser::class);        
    }
}
