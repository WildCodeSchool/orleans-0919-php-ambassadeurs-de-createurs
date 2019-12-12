<?php

namespace App\Repository;

use App\Entity\Duty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Duty|null find($id, $lockMode = null, $lockVersion = null)
 * @method Duty|null findOneBy(array $criteria, array $orderBy = null)
 * @method Duty[]    findAll()
 * @method Duty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DutyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Duty::class);
    }
}
