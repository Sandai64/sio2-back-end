<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\ProductKind;
use App\Entity\Tax;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Sample category');
        $category->setDescription('A category created as an initial system fill.');
        $category->setSlug('sample_category');
        $category->setIsHidden(false);
        $manager->persist($category);

        $product_kind = new ProductKind();
        $product_kind->setName('Sample product kind');
        $product_kind->setSlug('sample_product_kind');
        $product_kind->setDescription('Description of sample product kind');
        $manager->persist($product_kind);

        $tax = new Tax();
        $tax->setPercentage(20.0);
        $manager->persist($tax);

        for ($i = 0; $i <= 8; $i++)
        {
            $product = new Product();
            $product->setName('Sample product ' . $i);
            $product->setDescription('Description of sample product ' . $i);
            $product->setPriceTaxFree(1.99);
            $product->setIsHidden(false);
            $product->setIdCategory($category->getId());
            $product->setSlug('sample_product_' . $i);

            $product_kind->addProduct($product);
            $category->addProduct($product);
            $tax->addProduct($product);

            $manager->persist($product);
        }

        // Create an administrator user
        $user_admin = new User();
        $user_admin->setUsername('admin');
        // Generated using Symfony's internal password hashing utility
        // For password : 'admin'
        $user_admin->setPassword('$2y$13$YKv/PZ5QL2lWnj1gPjiB3e6SlSTBsix0lnwYm95CfMF02hq6TeYi6');
        $user_admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($user_admin);

        $manager->flush();
    }
}
