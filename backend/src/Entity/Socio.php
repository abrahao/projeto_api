<?php
namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SocioRepository::class)]
class Socio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['socios:read', 'socios:write'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['socios:read', 'socios:write'])]
    private ?string $nome = null;

    #[ORM\Column(length: 11)]
    #[Groups(['socios:read', 'socios:write'])]
    private ?string $cpf = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['socios:read', 'socios:write'])]
    private ?string $telefone = null;

    #[ORM\ManyToOne(inversedBy: 'socios')]
    #[Groups(['socios:read', 'socios:write'])]
    private ?Empresa $empresa = null;

    #[ORM\Column]
    #[Groups(['socios:read', 'socios:write'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['socios:read', 'socios:write'])]
    private ?\DateTimeImmutable $updatedAt = null;

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): static
    {
        $this->nome = $nome;
        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): static
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(?string $telefone): static
    {
        $this->telefone = $telefone;
        return $this;
    }

    public function getEmpresa(): ?Empresa
    {
        return $this->empresa;
    }

    public function setEmpresa(?Empresa $empresa): static
    {
        $this->empresa = $empresa;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
