<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 40)]
    private ?string $prenom = null;

    #[ORM\Column(length: 40)]
    private ?string $email = null;

    #[ORM\Column(length: 40)]
    private ?string $adresse = null;

    #[ORM\Column(length: 40)]
    private ?string $tel = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;
    #[ApiSubresource]
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Possession::class)]
    private Collection $possessions;

    public function __construct()
    {
        $this->possessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return Collection<int, Possession>
     */
    #[Groups(['user:read'])]
    public function getPossessions(): Collection
    {
        return $this->possessions;
    }

    public function addPossession(Possession $possessions): static
    {
        if (!$this->possessions->contains($possessions)) {
            $this->possessions->add($possessions);
            $possessions->setUser($this);
        }
        return $this;
    }

    public function removePossessions(Possession $possessions): static
    {
        if ($this->possessions->removeElement($possessions)) {
            // set the owning side to null (unless already changed)
            if ($possessions->getUser() === $this) {
                $possessions->setUser(null);
            }
        }

        return $this;
    }
    private int $age;
 
    /**
     * @param \DateTimeInterface $birthDate
     * @return int
     * 
     */
    public function getAge(): int
    {
 
        //Calcule de l'age d'user
        $datetime1 = new \datetime('now'); // date actuelle
        $datetime2 = $this->getBirthDate();
        $age = $datetime1->diff($datetime2, true)->y; // le y = nombre d'années 
        
        
        return $age;
    }

}
