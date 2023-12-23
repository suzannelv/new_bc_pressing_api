<?php

namespace App\Repository;

use App\Entity\ProductSelected;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductSelected>
 *
 * @method ProductSelected|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductSelected|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductSelected[]    findAll()
 * @method ProductSelected[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductSelectedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductSelected::class);
    }

//    /**
//     * @return ProductSelected[] Returns an array of ProductSelected objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductSelected
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
