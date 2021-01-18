<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    
    public function findOrderwithStatus($status)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.state = :status')
            ->setParameter('status', $status)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getOrderPassed(){
        try {
            return $this->createQueryBuilder('o')
                ->select("COUNT(o.state)")
                ->andWhere("o.state = 'delivered'")
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException $e){
            throw $e;
        } catch (NonUniqueResultException $e){
            throw $e;
        }
    }

    public function getOrderInProgress(){
        try {
            return $this->createQueryBuilder('o')
                ->select("COUNT(o.state)")
                ->andWhere("o.state = 'in delivering' OR o.state = 'in preparation'")
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException $e){
            throw $e;
        } catch (NonUniqueResultException $e){
            throw $e;
        }
    }
}
