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

    #[Route("/import-factions", name: "app_import_factions", methods: ["GET"])]
    public function importFactions(): JsonResponse
    {
        $directory = $this->getParameter('kernel.project_dir') . '/assets/data/factions';

        $finder = new Finder();
        $finder->files()->name('factions.json')->in($directory);

        $files = iterator_to_array($finder);
        if (empty($files)) {
            return new JsonResponse([
                'message' => 'Aucun fichier factions trouvé',
                'success' => 0,
                'failure' => 1
            ]);
        }

        // first file found
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

    #[Route("/import-pilots", name: "app_import_pilots", methods: ["GET"])]
    public function importPilots(): JsonResponse
    {
        $directory = $this->getParameter('kernel.project_dir') . '/assets/data/pilots';
        $factionDir = ['galactic-empire', 'rebel-alliance', 'scum-and-villainy'];

        $finder = new Finder();
        $finder->files()->name('*.json')->in($directory);

        foreach ($factionDir as $faction) {
            $factionPath = $directory . '/' . $faction;

            if (is_dir($factionPath)) {

                $finder->files()->in($factionPath)->name('*.json');
                foreach ($finder as $file) {

                    $jsonContent = file_get_contents($file->getRealPath());
                    $data = json_decode($jsonContent, true);

                    if ($data) {
                        $this->importService->importShipsAndPilots($data);
                    } else {
                        return new JsonResponse(['error' => 'Erreur de décodage JSON dans ' . $file->getFilename()]);
                    }
                }
            } else {
                return new JsonResponse(['error' => 'Le dossier de faction ' . $faction . ' est introuvable.']);
            }
        }

        return new JsonResponse(['message' => 'Importation des pilotes terminée avec succès']);
    }
}
