<?php

namespace App\Entity;

use App\Repository\TraductionTargetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraductionTargetRepository::class)]
class TraductionTarget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $traduction;

    #[ORM\ManyToOne(targetEntity: traductionSource::class, inversedBy: 'targethassource')]
    #[ORM\JoinColumn(nullable: false)]
    private $traduction_source;

    #[ORM\ManyToOne(targetEntity: lang::class, inversedBy: 'targethaslang')]
    #[ORM\JoinColumn(nullable: false)]
    private $lang;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTraduction(): ?string
    {
        return $this->traduction;
    }

    public function setTraduction(string $traduction): self
    {
        $this->traduction = $traduction;

        return $this;
    }

    public function getTraductionSource(): ?traductionSource
    {
        return $this->traduction_source;
    }

    public function setTraductionSource(?traductionSource $traduction_source): self
    {
        $this->traduction_source = $traduction_source;

        return $this;
    }

    public function getLang(): ?lang
    {
        return $this->lang;
    }

    public function setLang(?lang $lang): self
    {
        $this->lang = $lang;

        return $this;
    }
}
