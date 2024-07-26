<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Form\SocioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SocioController extends AbstractController
{
    #[Route('/socio', name: 'app_socio')]
    public function index(): Response
    {
        return $this->render('socio/index.html.twig');
    }

    #[Route('/socio/new', name: 'app_socio_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $socio = new Socio();
        $form = $this->createForm(SocioType::class, $socio);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTimeImmutable();
            $socio->setCreatedAt($now);
            $socio->setUpdatedAt($now);

            $entityManager->persist($socio);
            $entityManager->flush();

            return $this->redirectToRoute('app_socio_list');
        }

        return $this->render('socio/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/socio/list', name: 'app_socio_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $socios = $entityManager->getRepository(Socio::class)->findAll();

        return $this->render('socio/list.html.twig', [
            'socios' => $socios,
        ]);
    }

    #[Route('/socio/{id}/edit', name: 'app_socio_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Socio $socio): Response
    {
        $form = $this->createForm(SocioType::class, $socio);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_socio');
        }

        return $this->render('socio/edit.html.twig', [
            'form' => $form->createView(),
            'socio' => $socio,
        ]);
    }

    #[Route('/socios/delete/{id}', name: 'app_socios_delete', methods: ['POST'])]
    public function delete(Request $request, Socio $socio, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$socio->getId(), $request->request->get('_token'))) {
            $entityManager->remove($socio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_socio');
    }

}
