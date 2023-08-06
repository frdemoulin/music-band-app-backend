<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[Route(path: '/album', name: 'album_index', methods: ['GET'])]
    public function index(EntityManagerInterface $em): Response
    {
        $formCreate = $this->createForm(AlbumType::class);
        $albums = $em->getRepository(Album::class)->findAll();

        return $this->render('album/index.html.twig', [
            'albums' => $albums,
            'formCreate' => $formCreate->createView(),
        ]);
    }

    #[Route(path: '/album/create', name: 'album_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();

            $em->persist($album);
            $em->flush();

            if ($album->getTitle()) {
                $this->addFlash('success', 'L\'album <span id="flashBoldSpan">'.$album->getTitle().'</span> a été créé avec succès');
            }

            return $this->redirectToRoute('album_index');
        }
    }

    #[Route(path: '/album/{id}', name: 'album_show', requirements: ['id' => '\d+'])]
    public function show(Album $album, Request $request): \Symfony\Component\HttpFoundation\Response
    {
        if ($request->isMethod('POST')) {
            $this->redirectToRoute('album_delete', [
                'id' => $album->getId(),
            ]);
        }

        return $this->render('album/show.html.twig', [
            'album' => $album,
        ]);
    }

    #[Route(path: '/album/{id}/edit', name: 'album_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function edit(Request $request, Album $album, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(AlbumType::class, $album);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { // si le formulaire d'édition a été soumis
            $em->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/edit.html.twig', [
            'form' => $form->createView(),
            'album' => $album,
            ]);
    }

    #[Route(path: '/album/{id}/delete', name: 'album_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function delete(Album $album, EntityManagerInterface $em): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $em->remove($album);
        $em->flush();

        $this->addFlash('success', 'L\'album <span id="flashBoldSpan">'.$album->getTitle().'</span> a été supprimé avec succès');

        return $this->redirectToRoute('album_index');
    }
}