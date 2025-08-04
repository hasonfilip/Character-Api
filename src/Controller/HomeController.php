<?php
namespace App\Controller;

use App\Service\CharacterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    #[Route('/characters')]
    public function reply(CharacterService $characterService): JsonResponse
    {
        return new JsonResponse([
            'characters_count' => $characterService->getTotalCount(),
            'average_age' => $characterService->getAverageAge(),
            'average_weight' => $characterService->getAverageWeight(),
            'characters' => $characterService->getAllCharactersWithRelations()
        ]);
    }
}
