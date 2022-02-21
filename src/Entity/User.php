<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 45)]
    private $username;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\ManyToMany(targetEntity: lang::class, inversedBy: 'userhaslang')]
    private $langhasuser;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Project::class)]
    private $projecthasuser;

    public function __construct()
    {
        $this->langhasuser = new ArrayCollection();
        $this->projecthasuser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

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

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, lang>
     */
    public function getLanghasuser(): Collection
    {
        return $this->langhasuser;
    }

    public function addLanghasuser(lang $langhasuser): self
    {
        if (!$this->langhasuser->contains($langhasuser)) {
            $this->langhasuser[] = $langhasuser;
        }

        return $this;
    }

    public function removeLanghasuser(lang $langhasuser): self
    {
        $this->langhasuser->removeElement($langhasuser);

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjecthasuser(): Collection
    {
        return $this->projecthasuser;
    }

    public function addProjecthasuser(Project $projecthasuser): self
    {
        if (!$this->projecthasuser->contains($projecthasuser)) {
            $this->projecthasuser[] = $projecthasuser;
            $projecthasuser->setUser($this);
        }

        return $this;
    }

    public function removeProjecthasuser(Project $projecthasuser): self
    {
        if ($this->projecthasuser->removeElement($projecthasuser)) {
            // set the owning side to null (unless already changed)
            if ($projecthasuser->getUser() === $this) {
                $projecthasuser->setUser(null);
            }
        }

        return $this;
    }
}
