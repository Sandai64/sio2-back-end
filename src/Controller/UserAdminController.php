<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserAdminController extends AbstractController
{
  private UserRepository         $user_repository;
  private SerializerInterface    $serializer;
  private EntityManagerInterface $entity_manager;
  private ValidatorInterface     $validator;

  public function __construct(
    UserRepository         $user_repository,
    SerializerInterface    $serializer,
    EntityManagerInterface $entity_manager,
    ValidatorInterface     $validator
  ){
    $this->user_repository = $user_repository;
    $this->serializer      = $serializer;
    $this->entity_manager  = $entity_manager;
    $this->validator       = $validator;
  }

  /**
   * User validator helper
   *
   * @param User $user
   * @return Response|null
   */
  private function validator_user(User $user) : ?Response
  {
    $errors = $this->validator->validate($user);

    if (count($errors))
    {
      $errorsJSON = $this->serializer->serialize($errors, 'json');
      return new JsonResponse($errorsJSON, Response::HTTP_BAD_REQUEST, [], true);
    }

    return null;
  }

  // Public functions

  /**
   * @Route("/api/admin/user/get/all", name="api_admin_user_get_all", methods={"POST"})
   */
  public function admin_get_all_users() : Response
  {
    $users     = $this->user_repository->findAll();
    $usersJSON = $this->serializer->serialize($users, 'json', ['groups' => 'list_users']);
    return new JsonResponse($usersJSON, Response::HTTP_OK, [], true);
  }
}
