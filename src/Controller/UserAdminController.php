<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class UserAdminController extends AbstractController
{
  private UserRepository         $user_repository;
  private SerializerInterface    $serializer;
  private EntityManagerInterface $entity_manager;
  private ValidatorInterface     $validator;
  private UserPasswordHasherInterface     $password_hasher;
  private JWTEncoderInterface $jwt_encoder;

  public function __construct(
    UserRepository         $user_repository,
    SerializerInterface    $serializer,
    EntityManagerInterface $entity_manager,
    ValidatorInterface     $validator,
    UserPasswordHasherInterface     $password_hasher,
    JWTEncoderInterface $jwt_encoder,
  ){
    $this->user_repository = $user_repository;
    $this->serializer      = $serializer;
    $this->entity_manager  = $entity_manager;
    $this->validator       = $validator;
    $this->password_hasher = $password_hasher;
    $this->jwt_encoder     = $jwt_encoder;
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
   * @Route("/api/admin/user/get/all", name="api_admin_user_get_all", methods={"GET"})
   */
  public function admin_get_all_users() : Response
  {
    $users     = $this->user_repository->findAll();
    $usersJSON = $this->serializer->serialize($users, 'json', ['groups' => 'list_users']);
    return new JsonResponse($usersJSON, Response::HTTP_OK, [], true);
  }

  #[Route('/api/admin/self/password/update', name: 'api-admin-self-password-update')]
  public function admin_self_update_password(Request $request)
  {
    $requestContent = json_decode($request->getContent(), true);

    try
    {
      $decoded_jwt = $this->jwt_encoder->decode($requestContent['token']);

      $user = $this->user_repository->findBy(['username' => $decoded_jwt['username']])[0];
      $new_password = $this->password_hasher->hashPassword($user, $requestContent['new_password']);
      $user->setPassword($new_password);
      $this->entity_manager->flush();
    }
    catch (Exception $e)
    {
      $json = json_encode([
        "status" => Response::HTTP_BAD_REQUEST,
        "error" => "Malformed JSON",
        "details" => $e,
      ]);

      return new JsonResponse($json, $json["status"], [], true);
    }

    return new JsonResponse(json_encode(['success' => 'Request OK']), Response::HTTP_OK, [], true);
  }

  #[Route('/api/admin/user/password/reset/{username}', name: 'api-admin-user-password-reset')]
  public function admin_user_password_reset(string $username)
  {
    try
    {
      $user = $this->user_repository->findBy(['username' => $username])[0];
      $new_password = $this->password_hasher->hashPassword($user, 'password');
      $user->setPassword($new_password);
      $this->entity_manager->flush();
    }
    catch (Exception $e)
    {
      $json = json_encode([
        "status" => Response::HTTP_BAD_REQUEST,
        "error" => "Malformed JSON",
        "details" => $e,
      ]);

      return new JsonResponse($json, $json["status"], [], true);
    }

    return new JsonResponse(json_encode(['success' => 'Reset OK']), Response::HTTP_OK, [], true);
  }
}
