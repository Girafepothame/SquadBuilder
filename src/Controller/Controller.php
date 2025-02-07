<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\FactionRepository;
use App\Repository\ShipRepository;
use App\Repository\PilotRepository;

use App\Entity\Pilot;

class Controller extends AbstractController
{
    private $factionRepository;
    private $shipRepository;
    private $pilotRepository;

    // Injection des dépendances via le constructeur
    public function __construct(FactionRepository $factionRepository, ShipRepository $shipRepository, PilotRepository $pilotRepository)
    {
        $this->factionRepository = $factionRepository;
        $this->shipRepository = $shipRepository;
        $this->pilotRepository = $pilotRepository;
    }

    #[Route('/', name: 'app_')]
    public function index(): Response
    {
        return $this->render('/index.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }

    #[Route("/database", name: "database")]
    public function database(SessionInterface $session)
    {
        // Vérifier si les données sont déjà en session
        if (!$session->has('factions')) {
            // Si les données ne sont pas en session, les charger depuis la base de données
            $factions = $this->factionRepository->findAll();
            $ships = $this->shipRepository->findAll();
            $pilots = $this->pilotRepository->findAll();

            $factionsArray = $this->factionRepository->findAllAsArray();
            $shipsArray = $this->shipRepository->findAllAsArray();
            $pilotsArray = $this->pilotRepository->findAllAsArray();

            // var_dump($factions, $ships, $pilots);
            // die();

            // Stocker les données dans la session
            $session->set('factions', $factionsArray);
            $session->set('ships', $shipsArray);
            $session->set('pilots', $pilotsArray);

        } else {
            // Récupérer les données depuis la session
            $factionsArray = $session->get('factions');
            $shipsArray = $session->get('ships');
            $pilotsArray = $session->get('pilots');
            
            
            // var_dump($factions, $ships, $pilots);
            // die();
        }
        
        usort($pilotsArray, function ($a, $b) {
            return $b['initiative'] <=> $a['initiative'];
        });



        // Passer les données à Twig
        return $this->render('database/index.html.twig', [
            'factions' => $factionsArray,
            'ships' => $shipsArray,
            'pilots' => $pilotsArray
        ]);
    }
}
