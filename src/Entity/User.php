<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['mail'], message: 'There is already an account with this mail')]
#[UniqueEntity(fields: ['mail'], message: 'There is already an account with this mail')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $mail = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkedin = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $github = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitter = null;

    #[ORM\ManyToMany(targetEntity: Certificate::class, inversedBy: 'user')]
    private Collection $certificate;

    #[ORM\ManyToMany(targetEntity: Experience::class, inversedBy: 'users')]
    private Collection $experience;

    // #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'profil')]
    // private Collection $projects;

    #[ORM\ManyToMany(targetEntity: Formation::class, mappedBy: 'user')]
    private Collection $formations;

    #[ORM\ManyToMany(targetEntity: project::class, inversedBy: 'users')]
    private Collection $project;

    public function __construct()
    {
        $this->certificate = new ArrayCollection();
        $this->experience = new ArrayCollection();
        // $this->projects = new ArrayCollection();
        $this->formations = new ArrayCollection();
        $this->project = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->mail;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_CONTRIBUTOR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getLinkedin(): ?string
    {
        return $this->linkedin;
    }

    public function setLinkedin(?string $linkedin): self
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    public function getGithub(): ?string
    {
        return $this->github;
    }

    public function setGithub(?string $github): self
    {
        $this->github = $github;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * @return Collection<int, certificate>
     */
    public function getCertificate(): Collection
    {
        return $this->certificate;
    }

    public function addCertificate(certificate $certificate): self
    {
        if (!$this->certificate->contains($certificate)) {
            $this->certificate->add($certificate);
        }

        return $this;
    }

    public function removeCertificate(certificate $certificate): self
    {
        $this->certificate->removeElement($certificate);

        return $this;
    }

    /**
     * @return Collection<int, experience>
     */
    public function getExperience(): Collection
    {
        return $this->experience;
    }

    public function addExperience(experience $experience): self
    {
        if (!$this->experience->contains($experience)) {
            $this->experience->add($experience);
        }

        return $this;
    }

    public function removeExperience(experience $experience): self
    {
        $this->experience->removeElement($experience);

        return $this;
    }

    // /**
    //  * @return Collection<int, Project>
    //  */
    // public function getProjects(): Collection
    // {
    //     return $this->projects;
    // }

    // public function addProject(Project $project): self
    // {
    //     if (!$this->projects->contains($project)) {
    //         $this->projects->add($project);
    //         $project->addProfil($this);
    //     }

    //     return $this;
    // }

    // public function removeProject(Project $project): self
    // {
    //     if ($this->projects->removeElement($project)) {
    //         $project->removeProfil($this);
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): self
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
            $formation->addUser($this);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): self
    {
        if ($this->formations->removeElement($formation)) {
            $formation->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, project>
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(project $project): self
    {
        if (!$this->project->contains($project)) {
            $this->project->add($project);
        }

        return $this;
    }

    public function removeProject(project $project): self
    {
        $this->project->removeElement($project);

        return $this;
    }
}
