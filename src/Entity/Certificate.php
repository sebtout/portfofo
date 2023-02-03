<?php

namespace App\Entity;

use App\Repository\CertificateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificateRepository::class)]
class Certificate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $certificatetitle = null;

    #[ORM\Column(nullable: true)]
    private ?int $yearofgraduation = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'certificate')]
    private Collection $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCertificatetitle(): ?string
    {
        return $this->certificatetitle;
    }

    public function setCertificatetitle(?string $certificatetitle): self
    {
        $this->certificatetitle = $certificatetitle;

        return $this;
    }

    public function getYearofgraduation(): ?int
    {
        return $this->yearofgraduation;
    }

    public function setYearofgraduation(?int $yearofgraduation): self
    {
        $this->yearofgraduation = $yearofgraduation;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->addCertificate($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            $user->removeCertificate($this);
        }

        return $this;
    }
}
