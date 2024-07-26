<?php

// backend/src/Controller/EmpresaController.php
namespace App\Controller;

use App\Entity\Empresa;
use App\Form\EmpresaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmpresaController extends AbstractController
{
    #[Route('/empresas', name: 'app_empresas')]
    public function index(): Response
    {
        return $this->render('empresa/index.html.twig', [
            'controller_name' => 'EmpresaController',
        ]);
    }

    #[Route('/empresas/new', name: 'app_empresas_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $empresa = new Empresa();
        $form = $this->createForm(EmpresaType::class, $empresa);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $now = new \DateTimeImmutable();
            $empresa->setCreatedAt($now);
            $empresa->setUpdatedAt($now);

            $entityManager->persist($empresa);
            $entityManager->flush();

            return $this->redirectToRoute('app_empresas_list');
        }

        return $this->render('empresa/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/empresas/list', name: 'app_empresas_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $empresas = $entityManager->getRepository(Empresa::class)->findAll();

        return $this->render('empresa/list.html.twig', [
            'empresas' => $empresas,
        ]);
    }

    #[Route('/empresas/{id}/edit', name: 'app_empresas_edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Empresa $empresa): Response
    {
        $form = $this->createForm(EmpresaType::class, $empresa);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_empresas');
        }

        return $this->render('empresa/edit.html.twig', [
            'form' => $form->createView(),
            'empresa' => $empresa,
        ]);
    }

    #[Route('/empresas/delete/{id}', name: 'app_empresas_delete', methods: ['POST'])]
    public function delete(Request $request, Empresa $empresa, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$empresa->getId(), $request->request->get('_token'))) {
            $entityManager->remove($empresa);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_empresas');
    }

}
