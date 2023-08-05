<?php

namespace App\Controller\Dashboard;

use App\Entity\Song;
use App\Entity\Album;
use App\Entity\AlbumSort;
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
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            // 'chart' => $chart,
        ]);
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
            ->setTitle(ucfirst($this->translator->trans('backend-title')))
            ->setFaviconPath('favicon.svg')
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard(ucfirst($this->translator->trans('home')), 'fa fa-home');
        yield MenuItem::section($this->translator->trans('discography'));
        yield MenuItem::linkToCrud(ucfirst($this->translator->trans('album.type')), 'fa-solid fa-sliders', AlbumSort::class);
        yield MenuItem::linkToCrud(ucfirst($this->translator->trans('albums')), 'fa-solid fa-compact-disc', Album::class);
        yield MenuItem::linkToCrud(ucfirst($this->translator->trans('songs')), 'fa-solid fa-music', Song::class);
    }
}
