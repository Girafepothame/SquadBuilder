<?php

namespace App\Controller;

use App\Service\ImportService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;

class ImportController extends AbstractController
{
    private $importService;

    public function __construct(ImportService $importService)
    {
        $this->importService = $importService;
    }

    /**
     * @Route("/import-factions", name="app_import_factions", methods={"GET"})
     */
    public function importFactions(): JsonResponse
    {
        // Dossier des factions
        $directory = $this->getParameter('kernel.project_dir') . '/assets/data/factions';

        // Finder pour récupérer le fichier JSON de factions
        $finder = new Finder();
        $finder->files()->name('faction.json')->in($directory);

        // On vérifie qu'il y a un fichier et on le récupère
        $files = iterator_to_array($finder);
        if (empty($files)) {
            return new JsonResponse([
                'message' => 'Aucun fichier factions trouvé',
                'success' => 0,
                'failure' => 1
            ]);
        }

        // On prend le premier fichier trouvé
        $file = reset($files);

        $jsonContent = file_get_contents($file->getRealPath());
        $data = json_decode($jsonContent, true);

        if ($data) {
            $result = $this->importService->importFactions($data);
            return new JsonResponse([
                'message' => $result,
                'success' => $result === "Données importées avec succès!" ? 1 : 0,
                'failure' => $result === "Données importées avec succès!" ? 0 : 1
            ]);
        } else {
            return new JsonResponse([
                'message' => 'Erreur dans le format du fichier factions',
                'success' => 0,
                'failure' => 1
            ]);
        }
    }

    /**
     * @Route("/import-pilots", name="app_import_pilots", methods={"GET"})
     */
    public function importPilots(): JsonResponse
    {
        // Dossier des pilotes, dans les sous-dossiers de factions
        $directory = $this->getParameter('kernel.project_dir') . '/assets/data/pilots';

        // Finder pour récupérer les fichiers JSON des vaisseaux (pilotes)
        $finder = new Finder();
        $finder->files()->name('*.json')->in($directory);

        $successCount = 0;
        $failureCount = 0;

        // Parcours les fichiers de vaisseaux (pilotes)
        foreach ($finder as $file) {
            $jsonContent = file_get_contents($file->getRealPath());
            $data = json_decode($jsonContent, true);

            if ($data) {
                $result = $this->importService->importShipsAndPilots($data);
                if ($result === "Données importées avec succès!") {
                    $successCount++;
                } else {
                    $failureCount++;
                }
            } else {
                $failureCount++;
            }
        }

        return new JsonResponse([
            'message' => 'Import des pilotes (vaisseaux) terminé',
            'success' => $successCount,
            'failure' => $failureCount
        ]);
    }
}
