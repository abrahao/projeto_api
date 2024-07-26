<?php

namespace App\Controller\Api;

use App\Entity\Empresa;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/empresas', name: 'api_empresas_')]
class EmpresaApiController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $empresas = $entityManager->getRepository(Empresa::class)->findAll();
        return $this->json($empresas);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $empresa = new Empresa();
        $empresa->setNome($data['nome']);
        $empresa->setCnpj($data['cnpj']);
        $empresa->setEndereco($data['endereco']);
        $empresa->setTelefone($data['telefone'] ?? null);
        $empresa->setCreatedAt(new \DateTimeImmutable());
        $empresa->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($empresa);
        $entityManager->flush();

        return $this->json($empresa, 201);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Empresa $empresa): JsonResponse
    {
        return $this->json($empresa);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, Empresa $empresa, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $empresa->setNome($data['nome']);
        $empresa->setCnpj($data['cnpj']);
        $empresa->setEndereco($data['endereco']);
        $empresa->setTelefone($data['telefone'] ?? null);
        $empresa->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->flush();

        return $this->json($empresa);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Empresa $empresa, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($empresa);
        $entityManager->flush();

        return $this->json(null, 204);
    }
}
