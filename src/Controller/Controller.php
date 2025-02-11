<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\FactionRepository;
use App\Repository\ShipRepository;
use App\Repository\PilotRepository;
use App\Repository\ActionRepository;
use App\Repository\StatRepository;

class Controller extends AbstractController
{
    private $factionRepository;
    private $shipRepository;
    private $pilotRepository;
    private $actionRepository;
    private $statRepository;

    // Injection des dépendances via le constructeur
    public function __construct(FactionRepository $factionRepository, ShipRepository $shipRepository,
        PilotRepository $pilotRepository, ActionRepository $actionRepository, StatRepository $statRepository)
    {
        $this->factionRepository = $factionRepository;
        $this->shipRepository = $shipRepository;
        $this->pilotRepository = $pilotRepository;
        $this->actionRepository = $actionRepository;
        $this->statRepository = $statRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('/index.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }

    #[Route("/database", name: "database")]
    public function database(SessionInterface $session)
    {
        if (!$session->has('factions')) {

            $factionsArray = $this->factionRepository->findAllAsArray();
            $shipsArray = $this->shipRepository->findAllAsArray();
            $pilotsArray = $this->pilotRepository->findAllAsArray();
            $actionsArray = $this->actionRepository->findAllAsArray();
            $statsArray = $this->statRepository->findAllAsArray();

            // var_dump($factions, $ships, $pilots);
            // die();

            $session->set('factions', $factionsArray);
            $session->set('ships', $shipsArray);
            $session->set('pilots', $pilotsArray);
            $session->set('actions', $actionsArray);
            $session->set('stats', $statsArray);

        } else {
            $factionsArray = $session->get('factions');
            $shipsArray = $session->get('ships');
            $pilotsArray = $session->get('pilots');
            $actionsArray = $session->get('actions');
            $statsArray = $session->get('stats');
            
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
            'pilots' => $pilotsArray,
            'actions' => $actionsArray,
            'stats' => $statsArray
        ]);
    }
}
