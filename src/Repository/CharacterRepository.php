<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    /**
     * Get the character count
     *
     * @return int
     */
    public function getCharacterCount(): int
    {
        return $this->count();
    }

    /**
     * Get an array of birthdays
     *
     * @return array
     */
    public function findAllBirthDates(): array
    {
        $results = $this->createQueryBuilder('c')
            ->select('c.born')
            ->where('c.born IS NOT NULL')
            ->getQuery()
            ->getArrayResult();

        return array_map(fn($row) => $row['born'], $results);
    }

    /**
     * Get an array of genders
     *
     * @return array
     */
    public function findAllGenders(): array
    {
        $results = $this->createQueryBuilder('c')
            ->select('c.gender')
            ->getQuery()
            ->getArrayResult();

        return array_map(fn($row) => $row['gender'], $results);
    }

    /**
     * Get average weight of characters
     *
     * @return float
     */
    public function getAverageWeight(): float
    {
        $qb = $this->createQueryBuilder('c')
            ->select('AVG(c.weight)')
            ->where('c.weight IS NOT NULL');

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result ? (float) $result : 0.0;
    }

    /**
     * Find all characters with their related nemeses and secrets
     *
     * @return Character[]
     */
    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.nemeses', 'n')
            ->leftJoin('n.secrets', 's')
            ->addSelect('n', 's')
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
