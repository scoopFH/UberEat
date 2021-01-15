<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    // /**
    //  * @return Restaurant[] Returns an array of Restaurant objects
    //  */

    public function findIfPromotion()
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.promotion is not NULL')
            ->andWhere("r.promotion != ''")
            ->getQuery()
            ->getResult();
    }

    public function restaurantsOrderBy($orderBy, $directionOrder = 'ASC')
    {
        return $this->createQueryBuilder('r')
            ->orderBy('r.' . $orderBy, $directionOrder)
            ->getQuery()
            ->getResult();
    }

    public function search($name, $orderBy, $directionOrder = 'ASC') {
        return $this->createQueryBuilder('r')
            ->andWhere('r.name LIKE :name')
            ->orderBy('r.' . $orderBy, $directionOrder)
            ->setParameter('name', '%'.$name.'%')
            ->getQuery()
            ->execute();
    }

    public function getTotal(){
        try {
            return $this->createQueryBuilder('r')
                ->select('COUNT(r.name) as totalResto')
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException $e) {
            throw $e;
        } catch (NonUniqueResultException $e) {
            throw $e;
        }
    }
}
