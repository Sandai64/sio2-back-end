<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProduitController extends AbstractController
{
    private ProduitRepository      $produit_repository;
    private SerializerInterface    $serializer;
    private EntityManagerInterface $entity_manager;
    private ValidatorInterface     $validator;

    public function __construct(ProduitRepository $produit_repository, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
      $this->produit_repository = $produit_repository;
      $this->serializer         = $serializer;
      $this->entityManager      = $entityManager;
      $this->validator          = $validator;
    }

    /**
     * @Route("/api/produit/get/all", name="api_produit_get_produits_all", methods={"GET"})
     */
    public function getAllProduits(): Response
    {
      $produits     = $this->produit_repository->findAll();
      $produitsJSON = $this->serializer->serialize($produits, 'json');
      return new JsonResponse($produitsJSON, Response::HTTP_OK, [], true);
    }

    /**
     * @Route("/api/produit/get/{produit_id}", name="api_produit_get_produits_by_id", methods={"GET"})
     */
    public function getProduitByID(int $produit_id): Response
    {
      $produit = $this->produit_repository->find($produit_id);

      if (!$produit)
      {
        $error = [
          "status" => Response::HTTP_NOT_FOUND,
          "error" => "The requested product (" . $produit_id . ") was not found."
        ];

        return new JsonResponse(json_encode($error), Response::HTTP_NOT_FOUND, [], true);
      }

      $produitJSON = $this->serializer->serialize($produit, 'json');
      return new JsonResponse($produitJSON, Response::HTTP_OK, [], true);
    }
}
