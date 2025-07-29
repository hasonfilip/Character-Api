<?php

namespace App\Entity;

use App\Repository\SecretRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'secret')]
#[ORM\Entity(repositoryClass: SecretRepository::class, readOnly: true)]
class Secret
{
    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $secretCode = null;

    #[ORM\ManyToOne(inversedBy: 'secrets')]
    #[ORM\JoinColumn(name: 'nemesis_id', referencedColumnName: 'id', nullable: false)]
    private ?Nemesis $nemesis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSecretCode(): ?string
    {
        return $this->secretCode;
    }

    public function getNemesis(): ?Nemesis
    {
        return $this->nemesis;
    }
}
