<?php

namespace App\Repository;

use App\Entity\NewsletterRegistree;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewsletterRegistree|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewsletterRegistree|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewsletterRegistree[]    findAll()
 * @method NewsletterRegistree[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsletterRegistreeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewsletterRegistree::class);
    }

    // /**
    //  * @return NewsletterRegistree[] Returns an array of NewsletterRegistree objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewsletterRegistree
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
