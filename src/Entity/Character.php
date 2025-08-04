<?php

namespace App\Entity;

use App\Repository\CharacterRepository;
use DateTimeImmutable;
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
    private ?DateTimeImmutable $born = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $inSpaceSince = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $beerConsumption = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $knowsTheAnswer = null;

    #[ORM\OneToMany(targetEntity: Nemesis::class, mappedBy: 'character')]
    private Collection $nemeses;

    public function __construct()
    {
        $this->nemeses = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @return string|null
     */
    public function getAbility(): ?string
    {
        return $this->ability;
    }

    /**
     * @return string|null
     */
    public function getMinimalDistance(): ?string
    {
        return $this->minimalDistance;
    }

    /**
     * @return string|null
     */
    public function getWeight(): ?string
    {
        return $this->weight;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getBorn(): ?DateTimeImmutable
    {
        return $this->born;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getInSpaceSince(): ?DateTimeImmutable
    {
        return $this->inSpaceSince;
    }

    /**
     * @return int|null
     */
    public function getBeerConsumption(): ?int
    {
        return $this->beerConsumption;
    }

    /**
     * @return bool|null
     */
    public function getKnowsTheAnswer(): ?bool
    {
        return $this->knowsTheAnswer;
    }

    /**
     * @return Collection<int, Nemesis>
     */
    public function getNemeses(): Collection
    {
        return $this->nemeses;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $nemesisData = array_map(fn($nemesis) => $nemesis->toArray(), $this->getNemeses()->toArray());

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
            'nemeses' => $nemesisData,
        ];
    }
}
