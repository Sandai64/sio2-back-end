<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
  private JWTEncoderInterface $jwt_encoder;

  public function __construct(JWTEncoderInterface $encoder)
  {
    $this->jwt_encoder = $encoder;
  }

  /**
   * @Route("/api/auth/jwt/test", name="api_auth_jwt_test", methods={"GET"})
   */
  public function get_all_categories() : Response
  {
    return new Response(null, Response::HTTP_OK, []);
  }
}
