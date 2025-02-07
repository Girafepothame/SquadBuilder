<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\{Action, Bonus, Charge, Dial, Faction, Force, Loadout, Maneuver, Pilot, Restriction, Ship, Side, Stat, Upgrade, UpgradeLoadout};

class ImportService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function importFactions(array $factionsData)
    {

        foreach($factionsData as $factionData) {
            $faction = $this->entityManager->getRepository(Faction::class)->findOneBy(['xws' => $factionData['xws']]);

            if(!$faction) {
                $faction = new Faction();
                $faction->setName($factionData['name']);
                $faction->setXws($factionData['xws']);
                $faction->setIcon($factionData['icon']);
    
                $this->entityManager->persist($faction);
            }

        }
        $this->entityManager->flush();
    }

    public function importShipsAndPilots(array $shipsData): void
    {
        $faction = $this->entityManager->getRepository(Faction::class)->findOneBy(['xws' => $shipsData['faction']]);

        if (!$faction) {
            throw new \Exception("Faction non trouvée pour XWS : " . $shipsData['faction']);
        }

        // Vérifie si un vaisseau avec le même xws et la même faction existe déjà
        $ship = $this->entityManager->getRepository(Ship::class)->findOneBy([
            'xws' => $shipsData['xws'],
            'faction' => $faction
        ]);

        // Si le vaisseau n'existe pas, on l'ajoute
        if (!$ship) {
            $ship = new Ship();
            $ship->setName($shipsData['name']);
            $ship->setXws($shipsData['xws']);
            $ship->setSize($shipsData['size']);
            $ship->setIcon($shipsData['icon'] ?? "");
            $ship->setDialCode($shipsData['dialCodes'][0]);
            $ship->setFaction($faction);

            $this->entityManager->persist($ship);
            $this->entityManager->flush(); // Flush ici pour obtenir l'ID avant d'ajouter ses relations
        }

        // Import des données associées
        $this->importManeuvers($shipsData['dial'], $ship);
        $this->importStats($shipsData['stats'], $ship);
        $this->importActions($shipsData['actions'], $ship);

        foreach ($shipsData['pilots'] as $pilotData) {
            // Vérifie si le pilote existe déjà avec le même XWS et le même vaisseau
            $pilot = $this->entityManager->getRepository(Pilot::class)->findOneBy([
                'xws' => $pilotData['xws'],
                'ship' => $ship
            ]);

            if (!$pilot) {
                $pilot = new Pilot();
                $pilot->setName($pilotData['name']);
                $pilot->setXws($pilotData['xws']);
                $pilot->setCaption($pilotData['caption'] ?? null);
                $pilot->setInitiative($pilotData['initiative']);
                $pilot->setLimited($pilotData['limited']);
                $pilot->setCost($pilotData['cost']);
                $pilot->setLoadout($pilotData['loadout'] ?? 0);
                $pilot->setAbility($pilotData['ability'] ?? null);
                $pilot->setText($pilotData['text'] ?? null);
                $pilot->setImage($pilotData['image'] ?? "");
                $pilot->setArtwork($pilotData['artwork']);
                $pilot->setShipAbility(isset($pilotData['shipAbility']) ? $pilotData['shipAbility']['name'] . ": " . $pilotData['shipAbility']['text'] : null);
                $pilot->setKeywords(implode(",", $pilotData['keywords'] ?? []));
                $pilot->setSlots(implode(",", $pilotData['slots'] ?? []));

                $pilot->setShip($ship);

                $this->entityManager->persist($pilot);
            }
        }

        $this->entityManager->flush(); // Flush final après avoir tout persisté
    }



    public function importManeuvers(array $maneuvers, Ship $ship): void
    {
        foreach ($maneuvers as $maneuverCode) {
            $maneuver = new Maneuver();
            $maneuver->setCode($maneuverCode);
            $maneuver->setShip($ship);

            $this->entityManager->persist($maneuver);
        }
    }

    public function importStats(array $stats, Ship $ship): void
    {
        foreach ($stats as $statData) {
            $stat = new Stat();
            $stat->setArc($statData['arc'] ?? null);
            $stat->setType($statData['type']);
            $stat->setValue($statData['value']);
            $stat->setRecovers($statData['recovers'] ?? null);
            $stat->setShip($ship);


            $this->entityManager->persist($stat);
        }
    }

    public function importActions(array $actions, Ship $ship): void
    {
        foreach ($actions as $actionData) {
            
            $action = new Action();
            $action->setDifficulty($actionData['difficulty']);
            $action->setType($actionData['type']);
            $action->setShip($ship);

            if (isset($actionData['linked'])) {
                
                $linkedAction = new Action();
                $linkedAction->setDifficulty($actionData['linked']['difficulty']);
                $linkedAction->setType($actionData['linked']['type']);
                $linkedAction->setShip($ship);
                
                $this->entityManager->persist($linkedAction);
                
                $action->setLinkedAction($linkedAction);
            }

            $this->entityManager->persist($action);
        }
    }


    // public function importUpgrades(array $upgradesData): void
    // {
    //     foreach ($upgradesData as $upgradeData) {
            
    //         $upgrade = new Upgrade();
    //         $upgrade->setName($upgradeData['name']);
    //         $upgrade->setXws($upgradeData['xws']);
    //         $upgrade->setCost($upgradeData['cost']['value']);

    //         $this->entityManager->persist($upgrade);

    //         $this->importSides($upgradeData['sides'], $upgrade);

    //         if (isset($upgradeData['restrictions'])) {
    //             $this->importRestrictions($upgradeData['restrictions'], $upgrade);
    //         }
    //     }

    //     // Sauvegarde dans la base de données
    //     $this->entityManager->flush();
    // }

    // public function importSides(array $sides, Upgrade $upgrade): void
    // {
    //     foreach ($sides as $sideData) {
    //         $side = new Side();
    //         $side->setTitle($sideData['title']);
    //         $side->setType($sideData['type']);
    //         $side->setAbility($sideData['ability']);
    //         $side->setImage($sideData['image']);
    //         $side->setArtwork($sideData['artwork']);
    //         $side->setSlots(implode(",", $sideData['slots'])); // Conversion de l'array en string
    //         $side->setUpgrade($upgrade);

    //         // Persistance du side
    //         $this->entityManager->persist($side);
    //     }
    // }

    // public function importRestrictions(array $restrictions, Upgrade $upgrade): void
    // {
    //     foreach ($restrictions as $restrictionData) {
    //         $restriction = new Restriction();
    //         $restriction->setType($restrictionData['type']);
    //         $restriction->setValue($restrictionData['value']);
    //         $restriction->setUpgrade($upgrade);

    //         $this->entityManager->persist($restriction);
    //     }
    // }

}
