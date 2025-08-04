<?php

namespace App\Service;

use App\Repository\CharacterRepository;
use DateTimeImmutable;

readonly class CharacterService
{
    public function __construct(private CharacterRepository $characterRepository)
    { }

    /**
     * @return array
     */
    public function getAllCharactersWithRelations(): array
    {
        $characters = $this->characterRepository->findAllWithRelations();

        return array_map(
            fn($character) => $character->toArray(),
            $characters
        );
    }

    /**
     * @return float
     */
    public function getAverageAge(): float
    {
        $birthDates = $this->characterRepository->findAllBirthDates();

        if (empty($birthDates)) {
            return 0.0;
        }

        $now = new DateTimeImmutable();
        $totalAge = 0;

        foreach ($birthDates as $birthDate) {
            if ($birthDate instanceof DateTimeImmutable) {
                $age = $now->diff($birthDate)->y;
                $totalAge += $age;
            }
        }

        return $totalAge / count($birthDates);
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->characterRepository->getCharacterCount();
    }

    /**
     * @return float
     */
    public function getAverageWeight(): float
    {
        return $this->characterRepository->getAverageWeight();
    }
}
