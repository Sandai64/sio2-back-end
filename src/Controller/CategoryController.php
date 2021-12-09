<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class CategoryController extends AbstractController
{
  private CategoryRepository     $category_repository;
  private SerializerInterface    $serializer;
  private EntityManagerInterface $entity_manager;
  private ValidatorInterface     $validator;

  public function __construct(CategoryRepository $category_repository, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator)
  {
    $this->category_repository = $category_repository;
    $this->serializer          = $serializer;
    $this->entity_manager      = $entityManager;
    $this->validator           = $validator;
  }

  /**
   * category validator helper
   *
   * @param Category $product
   * @return Response|null
   */
  private function validate_category(Category $category) : ?Response
  {
    $errors = $this->validator->validate($category);

    if (count($errors))
    {
      $errorsJSON = $this->serializer->serialize($errors, 'json');
      return new JsonResponse($errorsJSON, Response::HTTP_BAD_REQUEST, [], true);
    }

    return null;
  }

  /**
   * @Route("/api/category/get/all", name="api_category_get_all", methods={"GET"})
   */
  public function get_all_categories() : Response
  {
    $categories     = $this->category_repository->findAll();
    $categoriesJSON = $this->serializer->serialize($categories, 'json', ['groups' => 'list_category']);
    return new JsonResponse($categoriesJSON, Response::HTTP_OK, [], true);
  }

  /**
   * @Route("/api/category/get/{category_id}", name="api_category_get_by_id", methods={"GET"})
   */
  public function get_category_by_id(int $category_id) : Response
  {
    $category = $this->category_repository->find($category_id);

    if (!$category)
    {
      $error = [
        'status' => Response::HTTP_NOT_FOUND,
        'error'  => 'The requested category (' . $category_id . ') was not found.'
      ];

      return new JsonResponse(json_encode($error), Response::HTTP_NOT_FOUND, [], true);
    }

    $categoryJSON = $this->serializer->serialize($category, 'json', ['groups' => 'meta_category']);
    return new JsonResponse($categoryJSON, Response::HTTP_OK, [], true);
  }

  /**
   * @Route("/api/category/create", name="api_category_create", methods={"PUT"})
   */
  public function create_category(Request $request) : Response
  {
    try
    {
      $categoryJSON = $request->getContent();
      $category     = $this->serializer->deserialize($categoryJSON, category::class, 'json');
      $validator_response = $this->validate_category($category);

      if (is_null($validator_response))
      {
        throw new NotEncodableValueException();
      }
      
      $this->entity_manager->persist($category);
      $this->entity_manager->flush();
    }
    catch (NotEncodableValueException $e)
    {
      $error = [
        'status'  => Response::HTTP_BAD_REQUEST,
        'message' => 'Invalid JSON'
      ];

      return new JsonResponse(json_encode($error), Response::HTTP_BAD_REQUEST, [], true);
    }
  }

  /**
   * @Route("/api/category/delete/{category_id}", name="api_category_delete_by_id", methods={"DELETE"})
   */
  public function delete_category(int $category_id) : Response
  {
    try
    {
      $category = $this->category_repository->find($category_id);

      if (is_null($category))
      {
        throw new Exception();
      }

      $this->entity_manager->remove($category);
      $this->entity_manager->flush();
      return new JsonResponse();
    }
    catch (Exception $e)
    {
      $error = [
        'status'  => Response::HTTP_NOT_FOUND,
        'message' => 'Category not found'
      ];

      return new JsonResponse(json_encode($error), Response::HTTP_NOT_FOUND, [], true);
    }
  }

  /**
   * @Route("/api/category/update/{category_id}", name="api_category_update_by_id", methods={"PUT"})
   */
  public function update_category(Request $request, int $category_id) : Response
  {
    try
    {
      $categoryJSON = $request->getContent();
      $category     = $this->category_repository->find($category_id);
      $this->serializer->deserialize($categoryJSON, category::class, 'json', ['object_to_populate' => $category]);
      $validator_response = $this->validate_category($category);

      if (!is_null($validator_response))
      {
        return $validator_response;
      }

      $this->entity_manager->flush();
    }
    catch (NotEncodableValueException $e)
    {
      // TODO
    }
  }

  /**
   * @Route("/api/category/get/products/{category_id}", name="api_category_get_products_by_id", methods={"GET"})
   */
  public function get_all_products_by_category_id(int $category_id) : Response
  {
    $category = $this->entity_manager->find(category::class, $category_id);

    if (is_null($category))
    {
      $error = [
        'status'  => Response::HTTP_NOT_FOUND,
        'message' => 'Category not found'
      ];

      return new JsonResponse(json_encode($error), Response::HTTP_NOT_FOUND, [], true);
    }

    $products    = $category->getProducts();
    $producsJSON = $this->serializer->serialize($products, 'json', ['groups' => 'detail_category']);
    return new JsonResponse($producsJSON, Response::HTTP_OK, [], true);
  }

}
