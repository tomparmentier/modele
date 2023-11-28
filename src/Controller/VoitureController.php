<?php

namespace App\Controller;

use App\Entity\Voiture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class VoitureController extends AbstractController
{
    #[Route('/voiture', name: 'app_voiture')]
    public function index(): Response
    {
        return $this->render('voiture/index.html.twig', [
            'controller_name' => 'VoitureController',
        ]);
    }

    #[Route('/voiture/new', name: 'app_voiture')]
    public function new(EntityManagerInterface $entityManager) : Response
    {

        $voiture = new Voiture;
        $voiture->setNom('Mercedes');
        $voiture->setDescription('Classe A');
        $voiture->setPrix(30000);
        $voiture->setDateCreation(new \DateTime('now'));
        $entityManager->persist($voiture);
        $entityManager->flush();

        return new Response('ok');

    }

    #[Route('/voiture/show/{id}', name: 'app_voiture_show')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        //
        $repository = $entityManager->getRepository(Voiture::class);
        //ici $repository devient un objet voitureRepository
        $voiture = $repository->find($id);
        

        return $this->render('voiture/index.html.twig', [
            'voiture' => $voiture,
            //le 'id' n'est pas nécessaire car je le récupère dans twig avec le voiture.id
            'id' => $id,
        ]);

    }

    /*
    // fait pareil que la fonction juste au dessus ! en plus simple (aller voir la doc)
    // Fonctionne uniquement si j'utilise {id}
    #[Route('/voiture/{id}', name: 'app_voiture_show')]
    public function showByPk(Voiture $voiture): Response
    {
        
        return $this->render('voiture/showByPk.html.twig', [
            'voiture' => $voiture,
            // dans mon twig on peut toujours utiliser voiture.id(.nom,.prix, etc)
        ]);

    }

    // pareil qu'au dessus encore mais en utilisant un des attributs et il doit etre unique !
    #[Route('/voiture/find/{nom}', name: 'app_voiture_show')]
    public function showBySlug(Voiture $voiture): Response
    {
        
        return $this->render('voiture/showBySlug.html.twig', [
            'voiture' => $voiture,
            // dans mon twig on peut toujours utiliser voiture.id(.nom,.prix, etc)
        ]);

    }
    */






}
