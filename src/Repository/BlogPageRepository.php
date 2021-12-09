<?php

namespace App\Repository;

use App\Entity\BlogPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPage[]    findAll()
 * @method BlogPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPage::class);
    }

    // /**
    //  * @return BlogPage[] Returns an array of BlogPage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogPage
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
