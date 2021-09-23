<?php

namespace App\Repository;

use App\Entity\Topping;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Topping|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topping|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topping[]    findAll()
 * @method Topping[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ToppingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topping::class);
    }

    // /**
    //  * @return Topping[] Returns an array of Topping objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Topping
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
