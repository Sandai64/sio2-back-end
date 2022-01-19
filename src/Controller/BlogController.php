<?php

namespace App\Controller;

use App\Entity\BlogCategory;
use App\Entity\BlogPage;
use App\Repository\BlogCategoryRepository;
use App\Repository\BlogPageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BlogController extends AbstractController
{
  private BlogPageRepository     $post_repository;
  private BlogCategoryRepository $category_repository;
  private SerializerInterface    $serializer;
  private EntityManagerInterface $entity_manager;
  private ValidatorInterface     $validator;

  public function __construct
  (
    BlogPageRepository $post_repository,
    BlogCategoryRepository $category_repository,
    SerializerInterface $serializer,
    EntityManagerInterface $entity_manager,
    ValidatorInterface $validator
  )
  {
    $this->post_repository = $post_repository;
    $this->category_repository = $category_repository;
    $this->serializer = $serializer;
    $this->entity_manager = $entity_manager;
    $this->validator = $validator;
  }

  /*
  * Get all posts
  */
  #[Route('/api/blog/get/posts/all', name: 'api-blog-get-all')]
  public function get_all_posts(): Response
  {
    $blogPosts = $this->post_repository->findAll();
    $blogPostsJSON = $this->serializer->serialize($blogPosts, 'json', ['groups' => 'list_posts']);
    return new JsonResponse($blogPostsJSON, Response::HTTP_OK, [], true);
  }

  /*
  * Get post by ID
  */
  #[Route('/api/blog/get/post/{post_id}', name: 'api-blog-get-post-by-id')]
  public function get_post_by_id(int $post_id) : Response
  {
    $post = $this->post_repository->find($post_id);

    if (is_null($post))
    {
      $error = [
        'status' => Response::HTTP_NOT_FOUND,
        'error'  => 'The requested blog post (' . $post_id . ') was not found.'
      ];

      return new JsonResponse(json_encode($error), Response::HTTP_NOT_FOUND, [], true);
    }

    $postJSON = $this->serializer->serialize($post, 'json', ['groups' => 'list_posts']);
    return new JsonResponse($postJSON, Response::HTTP_OK, [], true);
  }

  /*
  * Get all categories
  */
  #[Route('/api/blog/get/categories/all', name: 'api-blog-get-categories-all')]
  public function blog_get_all_categories(): Response
  {
    $blogCategories = $this->category_repository->findAll();
    $blogCategoriesJSON = $this->serializer->serialize($blogCategories, 'json', ['groups' => 'list_categories']);
    return new JsonResponse($blogCategoriesJSON, Response::HTTP_OK, [], true);
  }

  /*
  * Get category by ID
  */
  #[Route('/api/blog/get/category/{category_id}', name: 'api-blog-get-category-by-id')]
  public function blog_get_category_by_id(int $category_id) : Response
  {
    $category = $this->category_repository->find($category_id);

    if (is_null($category))
    {
      $error = [
        'status' => Response::HTTP_NOT_FOUND,
        'error'  => 'The requested blog category (' . $category_id . ') was not found.'
      ];

      return new JsonResponse(json_encode($error), Response::HTTP_NOT_FOUND, [], true);
    }

    $categoryJSON = $this->serializer->serialize($category, 'json', ['groups' => 'list_categories']);
    return new JsonResponse($categoryJSON, Response::HTTP_OK, [], true);
  }

  /*
  * Remove category by ID
  */
  #[Route('/api/writer/delete/category/{category_id}', name: 'api-writer-delete-category-by-id')]
  public function blog_remove_category_by_id(int $category_id) : Response
  {
    $category = $this->category_repository->find($category_id);
    
    if (is_null($category))
    {
      $error = [
        'status' => Response::HTTP_NOT_FOUND,
        'message' => 'The request blog category (' . $category_id . ') was not found.'
      ];

      $errorJSON = $this->serializer->serialize($error, 'json');
      return new JsonResponse($errorJSON, Response::HTTP_NOT_FOUND, [], true);
    }
    
    $this->entity_manager->remove($category);
    return new Response();
  }

  /*
  * Remove post by ID
  */
  #[Route('/api/writer/delete/post/{post_id}', name: 'api-writer-delete-post-by-id')]
  public function blog_remove_post_by_id(int $post_id) : Response
  {
    $post = $this->category_repository->find($post_id);
    
    if (is_null($post))
    {
      $error = [
        'status' => Response::HTTP_NOT_FOUND,
        'message' => 'The request blog post (' . $post_id . ') was not found.'
      ];

      $errorJSON = $this->serializer->serialize($error, 'json');
      return new JsonResponse($errorJSON, Response::HTTP_NOT_FOUND, [], true);
    }
    
    $this->entity_manager->remove($post);
    return new Response();
  }

  /*
  * Create a new post
  */
  #[Route('/api/writer/create/post', name: 'api-writer-create-post')]
  public function blog_create_post(Request $request) : Response
  {
    try 
    {
      $postJSON = $request->getContent();
      $post     = $this->serializer->deserialize($postJSON, BlogPage::class, 'json');

      $this->entity_manager->persist($post);
      $this->entity_manager->flush();

      // Send back an HTTP response
      return new JsonResponse($postJSON, Response::HTTP_CREATED, [], true);
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

  /*
  * Create a new category
  */
  #[Route('/api/writer/create/category', name: 'api-writer-create-category')]
  public function blog_create_category(Request $request) : Response
  {
    try 
    {
      $categoryJSON = $request->getContent();
      $category     = $this->serializer->deserialize($categoryJSON, BlogCategory::class, 'json');

      $this->entity_manager->persist($category);
      $this->entity_manager->flush();

      // Send back an HTTP response
      return new JsonResponse($categoryJSON, Response::HTTP_CREATED, [], true);
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
}
