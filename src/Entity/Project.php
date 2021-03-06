<?php

namespace App\Entity;

use App\Entity\Lang;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 45)]
    private $name;

    #[ORM\Column(type: 'boolean')]
    private $block_sources;

    #[ORM\Column(type: 'boolean')]
    private $is_deleted;

    #[ORM\Column(type: 'datetime')]
    private $date_add;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projecthasuser')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Lang::class, inversedBy: 'projecthaslang')]
    #[ORM\JoinColumn(nullable: false)]
    private $lang;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: TraductionSource::class, orphanRemoval: true)]
    private $traductionSourceshasproject;

    #[ORM\ManyToMany(targetEntity: Lang::class)]
    private $langtotranslate;

    public function __construct()
    {
        $this->traductionSourceshasproject = new ArrayCollection();
        $this->langtotranslate = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    // Register/edit Magic Method to Print the name of the project (in form edit and new)
    public function __toString()
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBlockSources(): ?bool
    {
        return $this->block_sources;
    }

    public function setBlockSources(bool $block_sources): self
    {
        $this->block_sources = $block_sources;

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(bool $is_deleted): self
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

    public function getDateAdd(): ?\DateTimeInterface
    {
        return $this->date_add;
    }

    public function setDateAdd(\DateTimeInterface $date_add): self
    {
        $this->date_add = $date_add;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLang(): ?Lang
    {
        return $this->lang;
    }

    public function setLang(?Lang $lang): self
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * @return Collection<int, TraductionSource>
     */
    public function getTraductionSourceshasproject(): Collection
    {
        return $this->traductionSourceshasproject;
    }

    public function addTraductionSourceshasproject(TraductionSource $traductionSourceshasproject): self
    {
        if (!$this->traductionSourceshasproject->contains($traductionSourceshasproject)) {
            $this->traductionSourceshasproject[] = $traductionSourceshasproject;
            $traductionSourceshasproject->setProject($this);
        }

        return $this;
    }

    public function removeTraductionSourceshasproject(TraductionSource $traductionSourceshasproject): self
    {
        if ($this->traductionSourceshasproject->removeElement($traductionSourceshasproject)) {
            // set the owning side to null (unless already changed)
            if ($traductionSourceshasproject->getProject() === $this) {
                $traductionSourceshasproject->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lang>
     */
    public function getLangtotranslate(): Collection
    {
        return $this->langtotranslate;
    }

    public function addLangtotranslate(Lang $langtotranslate): self
    {
        if (!$this->langtotranslate->contains($langtotranslate)) {
            $this->langtotranslate[] = $langtotranslate;
        }

        return $this;
    }

    public function removeLangtotranslate(Lang $langtotranslate): self
    {
        $this->langtotranslate->removeElement($langtotranslate);

        return $this;
    }
}
