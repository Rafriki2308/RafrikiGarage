<?php

namespace App\Repository;

use App\Entity\Worksheet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Worksheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Worksheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Worksheet[]    findAll()
 * @method Worksheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorksheetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Worksheet::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Worksheet $entity, bool $flush = true): void
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
    public function remove(Worksheet $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Worksheet[] Returns an array of Worksheet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @return Worksheet Returns a Worksheet object
     */
    public function findOneWorksheetByWorksheetNum($value): ?Worksheet
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
    
}
