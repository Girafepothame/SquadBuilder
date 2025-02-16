<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Entity\Squadron;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

use App\Repository\FactionRepository;
use App\Repository\ShipRepository;
use App\Repository\PilotRepository;
use App\Repository\ActionRepository;
use App\Repository\StatRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[IsGranted('ROLE_USER')] // Restreint l'accès aux utilisateurs connectés
final class SquadBuilderController extends AbstractController
{
    private FactionRepository $factionRepository;
    private ShipRepository $shipRepository;
    private PilotRepository $pilotRepository;
    private ActionRepository $actionRepository;
    private StatRepository $statRepository;

    public function __construct(
        FactionRepository $factionRepository,
        ShipRepository $shipRepository,
        PilotRepository $pilotRepository,
        ActionRepository $actionRepository,
        StatRepository $statRepository
    ) {
        $this->factionRepository = $factionRepository;
        $this->shipRepository = $shipRepository;
        $this->pilotRepository = $pilotRepository;
        $this->actionRepository = $actionRepository;
        $this->statRepository = $statRepository;
    }

    #[Route("/squadBuilder", name: "app_squad_builder")]
    public function squadBuilder(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('info', 'You must be logged in to access the Squad Builder.');
            return $this->redirectToRoute('app_auth'); // Redirection vers login
        }

        $squadrons = $entityManager->getRepository(Squadron::class)->findBy(['user' => $user]);

        // dump($squadrons);
        // die();


        return $this->render('squad_builder/index.html.twig', [
            'factions' => $this->factionRepository->findAllAsArray(),
            'ships' => $this->shipRepository->findAllAsArray(),
            'pilots' => $this->pilotRepository->findAllAsArray(),
            'actions' => $this->actionRepository->findAllAsArray(),
            'stats' => $this->statRepository->findAllAsArray(),
            'squadrons' => $squadrons,
        ]);
    }

    #[Route('/squadron/new', name: 'app_squadron_new', methods: ['POST'])]
    public function newSquadron(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('info', 'You must be logged in to access the Squad Builder.');
            return $this->redirectToRoute('app_auth'); // Redirection vers login
        }

        $factionId = $request->request->get('faction');
        $name = $request->request->get('name');

        if (empty($factionId) || empty($name)) {
            $this->addFlash('danger', 'Invalid data.');
            return $this->redirectToRoute('app_squad_builder');
        }

        $faction = $entityManager->getRepository(Faction::class)->find($factionId);
        if (!$faction) {
            $this->addFlash('danger', 'Invalid faction.');
            return $this->redirectToRoute('app_squad_builder');
        }

        $squadron = new Squadron();
        $squadron->setName($name);
        $squadron->setFaction($faction);
        $squadron->setUser($user);

        $entityManager->persist($squadron);
        $entityManager->flush();

        $this->addFlash('success', 'Successfully created squadron.');

        return $this->redirectToRoute('app_squad_builder');
    }

    #[Route('/squadron/{id}', name: 'app_squadron_delete', methods: ['DELETE'])]
    public function delete(Squadron $squadron, EntityManagerInterface $entityManager, Request $request): JsonResponse
    {
        $entityManager->remove($squadron);
        $entityManager->flush();
    
        // Ajout du flash message via la session du request
        $request->getSession()->getFlashBag()->add('success', 'Squadron supprimé avec succès.');
    
        return new JsonResponse(['message' => 'Squadron supprimé'], Response::HTTP_OK);
    }
    

}
