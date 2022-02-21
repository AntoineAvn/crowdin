<?php

namespace App\Entity;

use App\Repository\LangRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LangRepository::class)]
class Lang
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 45)]
    private $name;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'langhasuser')]
    private $userhaslang;

    #[ORM\OneToMany(mappedBy: 'lang', targetEntity: Project::class)]
    private $projecthaslang;

    #[ORM\OneToMany(mappedBy: 'lang', targetEntity: TraductionTarget::class)]
    private $targethaslang;

    public function __construct()
    {
        $this->userhaslang = new ArrayCollection();
        $this->projecthaslang = new ArrayCollection();
        $this->targethaslang = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserhaslang(): Collection
    {
        return $this->userhaslang;
    }

    public function addUserhaslang(User $userhaslang): self
    {
        if (!$this->userhaslang->contains($userhaslang)) {
            $this->userhaslang[] = $userhaslang;
            $userhaslang->addLanghasuser($this);
        }

        return $this;
    }

    public function removeUserhaslang(User $userhaslang): self
    {
        if ($this->userhaslang->removeElement($userhaslang)) {
            $userhaslang->removeLanghasuser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjecthaslang(): Collection
    {
        return $this->projecthaslang;
    }

    public function addProjecthaslang(Project $projecthaslang): self
    {
        if (!$this->projecthaslang->contains($projecthaslang)) {
            $this->projecthaslang[] = $projecthaslang;
            $projecthaslang->setLang($this);
        }

        return $this;
    }

    public function removeProjecthaslang(Project $projecthaslang): self
    {
        if ($this->projecthaslang->removeElement($projecthaslang)) {
            // set the owning side to null (unless already changed)
            if ($projecthaslang->getLang() === $this) {
                $projecthaslang->setLang(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TraductionTarget>
     */
    public function getTargethaslang(): Collection
    {
        return $this->targethaslang;
    }

    public function addTargethaslang(TraductionTarget $targethaslang): self
    {
        if (!$this->targethaslang->contains($targethaslang)) {
            $this->targethaslang[] = $targethaslang;
            $targethaslang->setLang($this);
        }

        return $this;
    }

    public function removeTargethaslang(TraductionTarget $targethaslang): self
    {
        if ($this->targethaslang->removeElement($targethaslang)) {
            // set the owning side to null (unless already changed)
            if ($targethaslang->getLang() === $this) {
                $targethaslang->setLang(null);
            }
        }

        return $this;
    }
}
