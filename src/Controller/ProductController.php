<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
  private ProductRepository      $product_repository;
  private SerializerInterface    $serializer;
  private EntityManagerInterface $entity_manager;
  private ValidatorInterface     $validator;

  public function __construct(
    ProductRepository $product_repository,
    SerializerInterface $serializer,
    EntityManagerInterface $entityManager,
    ValidatorInterface $validator
  ){
    $this->product_repository = $product_repository;
    $this->serializer         = $serializer;
    $this->entity_manager     = $entityManager;
    $this->validator          = $validator;
  }

  /**
   * product validator helper
   *
   * @param Product $product
   * @return Response|null
   */
  private function validate_product(Product $product) : ?Response
  {
    $errors = $this->validator->validate($product);

    if (count($errors))
    {
      $errorsJSON = $this->serializer->serialize($errors, 'json');
      return new JsonResponse($errorsJSON, Response::HTTP_BAD_REQUEST, [], true);
    }

    return null;
  }

  /*
  * Public Functions
  */

  /**
   * @Route("/api/product/get/all", name="api_product_get_all", methods={"GET"})
   */
  public function get_all_products() : Response
  {
    $products     = $this->product_repository->findAll();
    $productsJSON = $this->serializer->serialize($products, 'json', ['groups' => 'list_product']);
    return new JsonResponse($productsJSON, Response::HTTP_OK, [], true);
  }

  /**
   * @Route("/api/product/get/{product_id}", name="api_product_get_by_id", methods={"GET"})
   */
  public function get_product_by_id(int $product_id) : Response
  {
    $product = $this->product_repository->find($product_id);

    if (!$product)
    {
      $error = [
        'status' => Response::HTTP_NOT_FOUND,
        'error'  => 'The requested product (' . $product_id . ') was not found.'
      ];

      return new JsonResponse(json_encode($error), Response::HTTP_NOT_FOUND, [], true);
    }

    $productJSON = $this->serializer->serialize($product, 'json', ['groups' => 'list_product']);
    return new JsonResponse($productJSON, Response::HTTP_OK, [], true);
  }

  /**
   * @Route("/api/product/create", name="api_product_create", methods={"PUT"})
   */
  public function create_product(Request $request) : Response
  {
    try 
    {
      $productJSON = $request->getContent();
      $product     = $this->serializer->deserialize($productJSON, product::class, 'json');

      // Null if checks passed, custom return Response handled automatically
      $validator_response = $this->validate_product($product);

      if (!is_null($validator_response))
      {
        return $validator_response;
      }

      $this->entity_manager->persist($product);
      $this->entity_manager->flush();

      // Send back an HTTP response
      return new JsonResponse($productJSON, Response::HTTP_CREATED, [], true);
    }
    catch (NotEncodableValueException $e)
    {
      $error = [
        'status' => Response::HTTP_BAD_REQUEST,
        'message' => 'Invalid JSON'
      ];

      $errorJSON = json_encode($error);
      return new JsonResponse($errorJSON, Response::HTTP_BAD_REQUEST, [], true);
    }
  }

  // TODO handle access-control, this should be OP-only
  /**
   * @Route("/api/product/delete/{product_id}", name="api_product_delete", methods={"DELETE"})
   */
  public function delete_product(int $product_id) : Response
  {
    $product = $this->product_repository->find($product_id);

    if (is_null($product))
    {
      // Product not found
      $error = [
        'status' => Response::HTTP_NOT_FOUND,
        'message' => 'Product not found'
      ];

      $errorJSON = json_encode($error);
      return new JsonResponse($errorJSON, Response::HTTP_NOT_FOUND, [], true);
    }

    $this->entity_manager->remove($product);
    $this->entity_manager->flush();

    return new JsonResponse();
  }

  /**
   * @Route("/api/product/{product_id}", name="api_product_update_by_id", methods={"PUT"})
   */
  public function update_product(Request $request, int $product_id) : Response
  {
    try
    {
      $productJSON = $request->getContent();
      $product = $this->product_repository->find($product_id);

      // Deserialize data
      $this->serializer->deserialize($productJSON, product::class, 'json', ['object_to_populate' => $product]);
      $validator_response = $this->validate_product($product);

      // Check data validation
      if (!is_null($validator_response))
      {
        return $validator_response;
      }

      $this->entity_manager->flush();
      return new JsonResponse(null, Response::HTTP_OK);
    }
    catch (NotEncodableValueException $e)
    {
      // TODO handle API error, that shouldn't happen
    }
  }
}
