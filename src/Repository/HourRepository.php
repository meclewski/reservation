<?php

namespace App\Repository;

use App\Entity\Hour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hour[]    findAll()
 * @method Hour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HourRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hour::class);
    }

    // /**
    //  * @return Hour[] Returns an array of Hour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hour
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
