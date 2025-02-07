<?php

namespace App\Controller;

use App\Service\ImportService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DatabaseController extends AbstractController
{
    private $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    #[Route('/database', name: 'app_database')]
    public function index(): Response
    {
        return $this->render('database/index.html.twig', [
            'controller_name' => 'DatabaseController',
        ]);
    }

    #[Route('/back', name: 'go_back')]
    public function goBack(Request $request): RedirectResponse
    {
        $referer = $request->headers->get('referer');

        if ($referer) {
            return $this->redirect($referer);
        }

        // Si pas de referer, redirection vers une page par défaut
        return $this->redirectToRoute('index');
    }

}
