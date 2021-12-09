<?php

namespace App\Repository;

use App\Entity\ProductKind;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductKind|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductKind|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductKind[]    findAll()
 * @method ProductKind[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductKindRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductKind::class);
    }

    // /**
    //  * @return ProductKind[] Returns an array of ProductKind objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductKind
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
