<?php

namespace App\Controller;

use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemController extends AbstractController
{
    /**
     * @Route("api/item", name="app_item_liste",methods={"GET"})
     */
    public function liste(ItemRepository $repo): Response
    {
        $items = $repo->findAll();
        

        return $this->json($items);
    }

    /**
     * @Route("api/item", name="app_item_ajouter",methods={"POST"})
     */
    public function ajouter(EntityManagerInterface $em, Request $request): Response
    {
        $objet = json_decode($request ->getContent());
        
        $item = new Item();
        $item->setTitle($objet->titre);
        $item->setIsCheck(false);

        $em->persist($item);
        $em->flush();

        return $this->json($item);
    }

     /**
     * @Route("api/item/{id}", name="app_item_modifier",methods={"PUT"})
     */
    public function edit(Item $item,EntityManagerInterface $em): Response
    {
        $etat = ! $item->getIsCheck(); 
        $item->setIsCheck($etat);

        $em->flush();
        
        return $this->json($item);
    }
    

     /**
     * @Route("api/item/{id}", name="app_item_supprimer", methods={"DELETE"})
     */
    public function supprimer(Item $item,EntityManagerInterface $em): Response
    {
        $em->remove($item);
        $em->flush();
        
        return $this->json($item);
    }
}
