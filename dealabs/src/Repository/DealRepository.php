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
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findDeal($id)
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->select('d, u')
            ->where('d.id = :id')
            ->setParameter('id', $id)
            ->join('d.auteur', 'u');

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * Find deal by id and get DealType in Deal.
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findDealAndDealTypeById($id) : ?Deal
    {
        $queryBuilder = $this->createQueryBuilder('deal');
        $queryBuilder->select('deal, dealType')
            ->where('deal.id = :id')
            ->setParameter('id', $id)
            ->join('deal.type', 'dealType');

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

    /**
     * Find all bons plans.
     *
     * @return array
     */
    public function findAllBonsPlans()
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->select('d, u')
            ->where('d.type = :id')
            ->setParameter('id', '1')
            ->join('d.auteur', 'u');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find all codes promo.
     *
     * @return array
     */
    public function findAllCodesPromo()
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->select('d, u')
            ->where('d.type = :id')
            ->setParameter('id', '2')
            ->join('d.auteur', 'u');

        return $queryBuilder->getQuery()->getResult();
    }
}
