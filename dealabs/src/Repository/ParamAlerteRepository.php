<?php

namespace App\Repository;

use App\Entity\ParamAlerte;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParamAlerte|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParamAlerte|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParamAlerte[]    findAll()
 * @method ParamAlerte[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParamAlerteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParamAlerte::class);
    }

    // /**
    //  * @return ParamAlerte[] Returns an array of ParamAlerte objects
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
    public function findOneBySomeField($value): ?ParamAlerte
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
