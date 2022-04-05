<?php

namespace App\Controller;

use App\Entity\Animals;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class AnimalsController extends AbstractController
{
    #[Route('/', name: 'app_animals')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $animals = $doctrine->getManager()->getRepository(Animals::class)->findAll();
        return $this->render('animals/index.html.twig', [
        "Animals" => $animals
        ]);
    }

    #[Route('/create', name: 'create_animals')]
    public function createAnimals(): Response
    {
        
        return $this->render('animals/create.html.twig', [
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_animals')]
    public function editAnimals($id): Response
    {
        return $this->render('animals/edit.html.twig', [
        ]);
    }

    #[Route('/details/{id}', name: 'details_animals')]
    public function detailsAnimals($id, ManagerRegistry $doctrine): Response
    {
        $animal = $doctrine->getManager()->getRepository(Animals::class)->find($id);
        return $this->render('animals/details.html.twig', [
            "Animal" => $animal
        ]);
    }
}
