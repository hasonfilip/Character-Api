<?php
namespace App\Controller;

use App\Repository\CharacterRepository;
use App\Service\CharacterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function getFullCharacterData(CharacterRepository $characterRepository, CharacterService $characterService): JsonResponse
    {
        $characters = $characterRepository->findCharactersWithFullNesting();
        $transformedCharacters = $characterService->transformCharacters($characters);

        return new JsonResponse(
            $transformedCharacters
        );
    }
}
