<?php

namespace App\Service;

use App\Entity\Character;

class CharacterService
{
    /**
     * @param Character[] $characters
     * @return array
     */
    public function transformCharacters(array $characters): array
    {
        $result = [];
        foreach ($characters as $character) {
            $characterData = [
                'id' => $character->getId(),
                'name' => $character->getName(),
                'gender' => $character->getGender(),
                'ability' => $character->getAbility(),
                'minimal_distance' => $character->getMinimalDistance(),
                'weight' => $character->getWeight(),
                'born' => $character->getBorn()?->format('Y-m-d H:i:s'),
                'in_space_since' => $character->getInSpaceSince()?->format('Y-m-d H:i:s'),
                'beer_consumption' => $character->getBeerConsumption(),
                'knows_the_answer' => $character->getKnowsTheAnswer(),
                'nemesises' => [],
            ];

            foreach ($character->getNemesises() as $nemesis) {
                $nemesisData = [
                    'id' => $nemesis->getId(),
                    'is_alive' => $nemesis->isIsAlive(),
                    'age' => $nemesis->getYears(),
                    'secrets' => [],
                ];

                foreach ($nemesis->getSecrets() as $secret) {
                    $nemesisData['secrets'][] = [
                        'id' => $secret->getId(),
                        'secret_code' => $secret->getSecretCode(),
                    ];
                }

                $characterData['nemesises'][] = $nemesisData;
            }

            $result[] = $characterData;
        }

        return $result;
    }
}
