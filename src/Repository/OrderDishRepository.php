<?php

namespace App\Repository;

use App\Entity\Dish;
use App\Entity\Order;
use App\Entity\OrderDish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OrderDish|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderDish|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderDish[]    findAll()
 * @method OrderDish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderDishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderDish::class);
    }

    // /**
    //  * @return OrderDish[] Returns an array of OrderDish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderDish
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getTotalIncome(){
        try {
            return $this->createQueryBuilder('odr')
                ->select('odr')
                ->from(Order::class,"od")
                ->innerJoin(Dish::class, "d",Join::WITH,"od.dish_id = d.id")
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException $e){
            throw $e;
        } catch (NonUniqueResultException $e){
            throw $e;
        }
    }
}
