<?php

namespace App\Repository;

use App\Entity\QuestionCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method QuestionCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionCategory[]    findAll()
 * @method QuestionCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionCategory::class);
    }

    // /**
    //  * @return QuestionCategory[] Returns an array of QuestionCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionCategory
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
