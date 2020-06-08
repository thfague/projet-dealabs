<?php

namespace App\Repository;

use App\Entity\Deal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Deal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deal[]    findAll()
 * @method Deal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deal::class);
    }

    /**
     * Find deal by id.
     * @return array
     */
    public function findDeal($id)
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->select('d, c, u')
            ->where('d.id = :id')
            ->setParameter('id', $id)
            ->join('d.commentaires', 'c')
            ->join('d.auteur', 'u');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find all deals.
     *
     * @return array
     */
    public function findAllDeals()
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->select('d, u')
            ->join('d.auteur', 'u');

        return $queryBuilder->getQuery()->getResult();
    }

    // /**
    //  * @return Deal[] Returns an array of Deal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Deal
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
