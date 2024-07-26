<?php
namespace App\Controller\Api;

use App\Entity\Empresa;
use App\Entity\Socio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/socios', name: 'api_socios_')]
class SocioApiController extends AbstractController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        $socios = $entityManager->getRepository(Socio::class)->findAll();
        return $this->json($socios, 200, [], ['groups' => 'socios:read']);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $socio = new Socio();
        $socio->setNome($data['nome']);
        $socio->setCpf($data['cpf']);
        $socio->setTelefone($data['telefone'] ?? null);
        $empresa = $entityManager->getRepository(Empresa::class)->find($data['empresa_id']);
        $socio->setEmpresa($empresa);
        $socio->setCreatedAt(new \DateTimeImmutable());
        $socio->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->persist($socio);
        $entityManager->flush();

        return $this->json($socio, 201, [], ['groups' => 'socios:read']);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Socio $socio): JsonResponse
    {
        return $this->json($socio, 200, [], ['groups' => 'socios:read']);
    }

    #[Route('/{id}', name: 'update', methods: ['PUT'])]
    public function update(Request $request, Socio $socio, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $socio->setNome($data['nome']);
        $socio->setCpf($data['cpf']);
        $socio->setTelefone($data['telefone'] ?? null);
        $empresa = $entityManager->getRepository(Empresa::class)->find($data['empresa_id']);
        $socio->setEmpresa($empresa);
        $socio->setUpdatedAt(new \DateTimeImmutable());

        $entityManager->flush();

        return $this->json($socio, 200, [], ['groups' => 'socios:read']);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Socio $socio, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($socio);
        $entityManager->flush();

        return $this->json(null, 204);
    }
}
