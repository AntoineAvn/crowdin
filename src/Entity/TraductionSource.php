<?php

namespace App\Entity;

use App\Entity\Project;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\TraductionSourceRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: TraductionSourceRepository::class)]
class TraductionSource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $source;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'traductionSourceshasproject')]
    #[ORM\JoinColumn(nullable: false)]
    private $project;

    #[ORM\OneToMany(mappedBy: 'traduction_source', targetEntity: TraductionTarget::class, orphanRemoval: true)]
    private $targethassource;

    public function __construct()
    {
        $this->targethassource = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection<int, TraductionTarget>
     */
    public function getTargethassource(): Collection
    {
        return $this->targethassource;
    }

    public function addTargethassource(TraductionTarget $targethassource): self
    {
        if (!$this->targethassource->contains($targethassource)) {
            $this->targethassource[] = $targethassource;
            $targethassource->setTraductionSource($this);
        }

        return $this;
    }

    public function removeTargethassource(TraductionTarget $targethassource): self
    {
        if ($this->targethassource->removeElement($targethassource)) {
            // set the owning side to null (unless already changed)
            if ($targethassource->getTraductionSource() === $this) {
                $targethassource->setTraductionSource(null);
            }
        }

        return $this;
    }
}
