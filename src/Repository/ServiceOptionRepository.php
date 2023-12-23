<?php

namespace App\Repository;

use App\Entity\ServiceOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ServiceOption>
 *
 * @method ServiceOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceOption[]    findAll()
 * @method ServiceOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceOptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceOption::class);
    }

//    /**
//     * @return ServiceOption[] Returns an array of ServiceOption objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ServiceOption
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
