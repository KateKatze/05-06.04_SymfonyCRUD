<?php
namespace App\Controller;
use App\Entity\Animals;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AnimalsType; // like the name of the file form
use DateTime;

class AnimalsController extends AbstractController
{
    #[Route('/', name: 'app_animals')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $animals = $doctrine->getManager()->getRepository(Animals::class)->findAll();
        return $this->render('animals/index.html.twig', [
        "animals" => $animals
        ]);
    }

    #[Route('/create', name: 'create_animals')]
    public function createAnimals(Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader): Response
    {
        $animals = new Animals();
        // dd($animals);
        $form = $this->createForm(AnimalsType::class, $animals);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // $now = new DateTime("now");
            $pictureFile = $form->get('picture')->getData();
            if($pictureFile){
                $pictureFileName = $fileUploader->upload($pictureFile);
                $animals->setPicture($pictureFileName);
            }
            // $animals->setCreateDate($now);
            // dd($animals);
            $animals = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($animals);
            $em->flush();

            $this->addFlash("notice", "New animal info has been added");
            return $this->redirectToRoute("app_animals");
        }
        return $this->render('animals/create.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/edit/{id}', name: 'edit_animals')]
    public function editAnimals($id, Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader): Response
    {
        $animals = $doctrine->getManager()->getRepository(Animals::class)->find($id);
        // dd($animals);
        $form = $this->createForm(AnimalsType::class, $animals);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // $now = new DateTime("now");
            $pictureFile = $form->get('picture')->getData();
            if($pictureFile){
                $pictureFileName = $fileUploader->upload($pictureFile);
                $animals->setPicture($pictureFileName);
            }
            // $animals->setCreateDate($now);
            // dd($animals);
            $animals = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($animals);
            // $users = $doctrine->getRepository(Users::class)->find(1);
            // $animals->setFkUser($users);
            // $animals->setFkUser(1); -> will be error
            $em->flush();

            $this->addFlash("notice", "Animal info has been updated");
            return $this->redirectToRoute("app_animals");
        }
        return $this->render('animals/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/details/{id}', name: 'details_animals')]
    public function detailsAnimals($id, ManagerRegistry $doctrine): Response
    {
        $animal = $doctrine->getManager()->getRepository(Animals::class)->find($id);
        return $this->render('animals/details.html.twig', [
            "animal" => $animal
        ]);
    }

    #[Route('/delete/{id}', name: 'delete_animals')]
    public function deleteAnimals($id, ManagerRegistry $doctrine): Response
    {
        $animal = $doctrine->getManager()->getRepository(Animals::class)->find($id);
        $em = $doctrine->getManager();
        $em->remove($animal);

        $em->flush();
        $this->addFlash("notice", "Animal info has been removed");
        return $this->redirectToRoute("app_animals");
    }
}
