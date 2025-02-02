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
            $faction = new Faction();
            $faction->setName($factionData['name']);
            $faction->setXws($factionData['xws']);
            $faction->setIcon($factionData['icon']);

            $this->entityManager->persist($faction);
        }
        $this->entityManager->flush();
    }

    public function importShipsAndPilots(array $shipsData): void
    {
        foreach ($shipsData as $shipData) {
            $ship = new Ship();
            $ship->setName($shipData['name']);
            $ship->setXws($shipData['xws']);
            $ship->setSize($shipData['size']);
            $ship->setIcon($shipData['icon']);

            $faction = $this->entityManager->getRepository(Faction::class)->findOneBy(['xws' => $shipData['faction']]);
            $ship->setFaction($faction);

            $this->entityManager->persist($ship);

            // Import associated data (dials, maneuvers, stats, actions, pilots)
            $this->importDialAndManeuvers($shipData['dialCodes'][0], $shipData['dial'], $ship);
            $this->importStats($shipData['stats'], $ship);
            $this->importActions($shipData['actions'], $ship);

            foreach ($shipData['pilots'] as $pilotData) {
                $pilot = new Pilot();
                
                $pilot->setName($pilotData['name']);
                $pilot->setXws($pilotData['xws']);
                $pilot->setCaption($pilotData['caption']);
                $pilot->setInitiative($pilotData['initiative']);
                $pilot->setLimited($pilotData['limited']);
                $pilot->setCost($pilotData['cost']);
                $pilot->setLoadout($pilotData['loadout']);
                $pilot->setAbility($pilotData['ability']);
                $pilot->setText($pilotData['text']);
                $pilot->setImage($pilotData['image']);
                $pilot->setArtwork($pilotData['artwork']);
                $pilot->setShipAbility($pilotData['shipAbility']);
                $pilot->setKeywords(implode(",", $pilotData['keywords']));
                $pilot->setSlots(implode(",", $pilotData['slots']));

                $pilot->setShip($ship);

                $this->entityManager->persist($pilot);
            }
        }

        $this->entityManager->flush();
    }


    public function importDialAndManeuvers(string $dialCode, array $maneuvers, Ship $ship): void
    {
        $dial = new Dial();
        $dial->setDialCodes($dialCode);
        $dial->setShip($ship);

        $this->entityManager->persist($dial);

        foreach ($maneuvers as $maneuverCode) {
            $maneuver = new Maneuver();
            $maneuver->setCode($maneuverCode);
            $maneuver->setDial($dial);

            $this->entityManager->persist($maneuver);
        }
    }

    public function importStats(array $stats, Ship $ship): void
    {
        foreach ($stats as $statData) {
            $stat = new Stat();
            $stat->setArc($statData['arc']);
            $stat->setType($statData['type']);
            $stat->setValue($statData['value']);
            $stat->setRecovers($statData['recovers']);
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
