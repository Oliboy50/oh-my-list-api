<?php

namespace App\Repository;

use App\Entity\Listitem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Listitem|null find($id, $lockMode = null, $lockVersion = null)
 * @method Listitem|null findOneBy(array $criteria, array $orderBy = null)
 * @method Listitem[]    findAll()
 * @method Listitem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListitemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Listitem::class);
    }

//    /**
//     * @return Listitem[] Returns an array of Listitem objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Listitem
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
