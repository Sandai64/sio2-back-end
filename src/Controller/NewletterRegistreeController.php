<?php

namespace App\Controller;

use App\Entity\NewsletterRegistree;
use App\Repository\NewsletterRegistreeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class NewletterRegistreeController extends AbstractController
{
  private NewsletterRegistreeRepository $registree_repository;
  private SerializerInterface           $serializer;
  private EntityManagerInterface        $entity_manager;
  private ValidatorInterface            $validator;

  public function __construct(
    NewsletterRegistreeRepository $registree_repository,
    SerializerInterface           $serializer,
    EntityManagerInterface        $entity_manager,
    ValidatorInterface            $validator
  )
  {
    $this->registree_repository = $registree_repository;
    $this->serializer           = $serializer;
    $this->entity_manager       = $entity_manager;
    $this->validator            = $validator;
  }

  /**
   * @Route("/api/admin/newsletter/get/all", name="api_admin_newsletter_registrees_get_all", methods={"GET"})
   */
  public function get_all_newsletter_registrees()
  {
    $registrees = $this->registree_repository->findAll();
    $registreesJSON = $this->serializer->serialize($registrees, 'json');
    return new JsonResponse($registreesJSON, Response::HTTP_OK, [], true);
  }

  /**
   * @Route("/api/newsletter/newsletter-registrees/get/all", name="api_newsletter_register", methods={"GET"})
   */
  public function register_to_newsletter(Request $request)
  {
    $registreeJSON = $request->getContent();
    $registree = $this->serializer->deserialize($registreeJSON, NewsletterRegistree::class, 'json');

    $this->entity_manager->persist($registree);
    $this->entity_manager->flush();

  }
}
