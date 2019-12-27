<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[]
     */
    public function findSearch(array $search): array
    {
        $query = $this->createQueryBuilder('u');

        if (!empty($search['department'])) {
            $query->join('u.department', 'd')
                ->where('d.id = :department')
                ->setParameter('department', $search['department']);
        }

        if (!empty($search['category'])) {
            $query->join('u.categories', 'c')
                ->andWhere('c.id = :category')
                ->setParameter('category', $search['category']);
        }

        if (!empty($search['duty'])) {
            $query->join('u.duties', 'd')
                ->andWhere('d.id = :duty')
                ->setParameter('duty', $search['duty']);
        }

        return $query->getQuery()->getResult();
    }
}
