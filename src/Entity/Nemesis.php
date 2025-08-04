<?php

namespace App\Entity;

use App\Repository\NemesisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'nemesis')]
#[ORM\Entity(repositoryClass: NemesisRepository::class, readOnly: true)]
class Nemesis
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $isAlive = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $years = null;

    #[ORM\ManyToOne(inversedBy: 'nemeses')]
    #[ORM\JoinColumn(name: 'character_id', referencedColumnName: 'id', nullable: true)]
    private ?Character $character = null;

    #[ORM\OneToMany(targetEntity: Secret::class, mappedBy: 'nemesis')]
    private Collection $secrets;

    public function __construct()
    {
        $this->secrets = new ArrayCollection();
    }

    public function toArray(): array
    {
        $secretsData = array_map(fn($secret) => $secret->toArray(), $this->getSecrets()->toArray());

        return [
            'id' => $this->getId(),
            'character_id' => $this->getCharacter()?->getId(),
            'is_alive' => $this->isIsAlive(),
            'years' => $this->getYears(),
            'secrets' => $secretsData,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsAlive(): ?bool
    {
        return $this->isAlive;
    }

    public function getYears(): ?int
    {
        return $this->years;
    }

    public function getCharacter(): ?Character
    {
        return $this->character;
    }

    /**
     * @return Collection<int, Secret>
     */
    public function getSecrets(): Collection
    {
        return $this->secrets;
    }
}
