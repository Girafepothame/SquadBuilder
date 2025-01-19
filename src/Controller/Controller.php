<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    #[Route('/', name: 'app_')]
    public function index(): Response
    {
        return $this->render('/index.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }

    #[Route('/database', name: 'app_database')]
    public function database(): Response
    {
        // recupération de la BDD
        
        return $this->redirectToRoute('app_database');
    }
}
