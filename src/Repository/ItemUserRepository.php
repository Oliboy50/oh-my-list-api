<?php

namespace App\Repository;

use App\Entity\ItemUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ItemUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemUser[]    findAll()
 * @method ItemUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ItemUser::class);
    }

//    /**
//     * @return ItemUser[] Returns an array of ItemUser objects
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
    public function findOneBySomeField($value): ?ItemUser
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
