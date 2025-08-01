<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: '"character"')]
#[ORM\Entity(repositoryClass: CharacterRepository::class, readOnly: true)]
class Character
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ability = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $minimalDistance = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $weight = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $born = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $inSpaceSince = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $beerConsumption = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $knowsTheAnswer = null;

    #[ORM\OneToMany(mappedBy: 'character', targetEntity: Nemesis::class)]
    private Collection $nemesises;

    public function __construct()
    {
        $this->nemesises = new ArrayCollection();
    }

    public function toArray(): array
    {
        $nemesisData = array_map(fn($nemesis) => $nemesis->toArray(), $this->getNemesises()->toArray());

        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'gender' => $this->getGender(),
            'ability' => $this->getAbility(),
            'minimal_distance' => $this->getMinimalDistance(),
            'weight' => $this->getWeight(),
            'born' => $this->getBorn()?->format('Y-m-d H:i:s'),
            'in_space_since' => $this->getInSpaceSince()?->format('Y-m-d H:i:s'),
            'beer_consumption' => $this->getBeerConsumption(),
            'knows_the_answer' => $this->getKnowsTheAnswer(),
            'nemesises' => $nemesisData,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getAbility(): ?string
    {
        return $this->ability;
    }

    public function getMinimalDistance(): ?string
    {
        return $this->minimalDistance;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function getBorn(): ?\DateTimeImmutable
    {
        return $this->born;
    }

    public function getInSpaceSince(): ?\DateTimeImmutable
    {
        return $this->inSpaceSince;
    }

    public function getBeerConsumption(): ?int
    {
        return $this->beerConsumption;
    }

    public function getKnowsTheAnswer(): ?bool
    {
        return $this->knowsTheAnswer;
    }

    /**
     * @return Collection<int, Nemesis>
     */
    public function getNemesises(): Collection
    {
        return $this->nemesises;
    }
}
