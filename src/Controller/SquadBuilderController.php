<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SquadBuilderController extends AbstractController
{
    #[Route('/squadBuilder', name: 'app_squad_builder')]
    public function index(): Response
    {
        return $this->render('squad_builder/index.html.twig', [
            'controller_name' => 'SquadBuilderController',
        ]);
    }
}
