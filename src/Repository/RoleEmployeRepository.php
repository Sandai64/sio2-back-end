<?php

namespace App\Repository;

use App\Entity\RoleEmploye;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoleEmploye|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleEmploye|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoleEmploye[]    findAll()
 * @method RoleEmploye[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleEmployeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoleEmploye::class);
    }

    // /**
    //  * @return RoleEmploye[] Returns an array of RoleEmploye objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoleEmploye
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
