<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addCustomer(Customer $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
    * @throws ORMException
    * @throws OptimisticLockException
    */
    public function remove(Customer $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    // * @return Customer[] Returns an array of Customer objects
    // */
    /*public function showAllCustomers()
    {
        return $this->findAll();
    }*/

    // /**
    // * @return Customer[] Returns an array of Customer objects
    // */
    /*public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }*/

    /**
    * @param $value
    * @return Customer|null Returns a Customer objects
    * @throws \Doctrine\ORM\NonUniqueResultException
    */
        public function findOneCustomerById($value)
        {
            return $this->createQueryBuilder('c')
                ->andWhere('c.id = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }

    /**
     * @param $value
     * @return Customer|null Returns a Customer objects
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneCustomerByIdCard($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idCard = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
