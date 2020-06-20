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

    /**
     * Find deals created by use ID.
     *
     * @return array
     */
    public function findDealsByUserId($id)
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->select('d, u')
            ->where('d.auteur = :id')
            ->setParameter('id', $id)
            ->join('d.auteur', 'u');

        return $queryBuilder->getQuery()->getResult();
    }

    /*public function searchByKeywords($criterias) {
        return $this->createQueryBuilder('d')
            ->andWhere('d.nom LIKE :criterias')
            ->andWhere('d.description LIKE :criterias')
            ->setParameter('criterias', '%'.$criterias.'%')
            ->getQuery()
            ->getResult();
    }*/
    public function searchByKeywords($criterias){
        $queryBuilder = $this->createQueryBuilder('d')
            ->where('d.nom LIKE :criterias')
            ->where('d.description LIKE :criterias')
            ->setParameter('criterias', $criterias);
        return $queryBuilder->getQuery()->getResult();
    }

    public function getNbDealsPostes($userId) : int{
        $queryBuilder = $this->createQueryBuilder('d')
            ->Select("count(d.id)")
            ->where('d.auteur = :userId')
            ->setParameter('userId', $userId);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function getRateHottestDeal($userId){
        $queryBuilder = $this->createQueryBuilder('d')
            ->Select("max(d.note)")
            ->where('d.auteur = :userId')
            ->setParameter('userId', $userId);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function getAverageRatesOneYear($userId){
        $date = new \DateTime('- 1 year');
        $queryBuilder = $this->createQueryBuilder('d')
            ->Select("avg(d.note)")
            ->where('d.auteur = :userId')
            ->andWhere('d.datePublication > :date ')
            ->setParameter('userId', $userId)
            ->setParameter('date', $date);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /*public function getPourcentHotDeals($userId){
        $queryBuilder = $this->createQueryBuilder('d')
            ->Select("avg(d.note)")
            ->where('d.auteur = :userId')
            ->andWhere('d.datepublication < add_months( trunc(sysdate), -12*20 )')
            ->setParameter('userId', $userId);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }*/
}
