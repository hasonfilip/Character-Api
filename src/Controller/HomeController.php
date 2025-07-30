<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function list(): Response
    {
        $dummy_data = ["name" => "Alice", "age" => 30, "city" => "Paris"];

        return new Response(
            json_encode($dummy_data)
        );
    }
}
