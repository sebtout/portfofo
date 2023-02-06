<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nameproject = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $link = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'project')]
    private Collection $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    // #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'projects')]
    // private Collection $profil;

    // public function __construct()
    // {
    //     $this->profil = new ArrayCollection();
    // }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameproject(): ?string
    {
        return $this->nameproject;
    }

    public function setNameproject(?string $nameproject): self
    {
        $this->nameproject = $nameproject;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    // /**
    //  * @return Collection<int, user>
    //  */
    // public function getProfil(): Collection
    // {
    //     return $this->profil;
    // }

    // public function addProfil(user $profil): self
    // {
    //     if (!$this->profil->contains($profil)) {
    //         $this->profil->add($profil);
    //     }

    //     return $this;
    // }

    //     public function removeProfil(user $profil): self
    //     {
    //         $this->profil->removeElement($profil);

    //         return $this;
    //     }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addProject($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeProject($this);
        }

        return $this;
    }
}
