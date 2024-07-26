<?php
// backend/src/Entity/Empresa.php
namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EmpresaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: EmpresaRepository::class)]
class Empresa
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['empresas:read', 'empresas:write', 'socios:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['empresas:read', 'empresas:write', 'socios:read'])]
    private ?string $nome = null;

    #[ORM\Column(length: 14)]
    #[Groups(['empresas:read', 'empresas:write', 'socios:read'])]
    private ?string $cnpj = null;

    #[ORM\Column(length: 255)]
    #[Groups(['empresas:read', 'empresas:write', 'socios:read'])]
    private ?string $endereco = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['empresas:read', 'empresas:write', 'socios:read'])]
    private ?string $telefone = null;

    #[ORM\Column]
    #[Groups(['empresas:read', 'empresas:write', 'socios:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['empresas:read', 'empresas:write', 'socios:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Socio::class, mappedBy: 'empresa')]
    #[Groups(['empresas:read'])]
    private Collection $socios;

    public function __construct()
    {
        $this->socios = new ArrayCollection();
    }

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

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): static
    {
        $this->cnpj = $cnpj;
        return $this;
    }

    public function getEndereco(): ?string
    {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): static
    {
        $this->endereco = $endereco;
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

    /**
     * @return Collection<int, Socio>
     */
    public function getSocios(): Collection
    {
        return $this->socios;
    }

    public function addSocio(Socio $socio): static
    {
        if (!$this->socios->contains($socio)) {
            $this->socios->add($socio);
            $socio->setEmpresa($this);
        }
        return $this;
    }

    public function removeSocio(Socio $socio): static
    {
        if ($this->socios->removeElement($socio)) {
            if ($socio->getEmpresa() === $this) {
                $socio->setEmpresa(null);
            }
        }
        return $this;
    }
}
