<?php

namespace App\Repository;

use App\Entity\Brand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Brand|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brand|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brand[]    findAll()
 * @method Brand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Brand::class);
    }

    public function findChosenCreator(): array
    {
        $query = $this->createQueryBuilder('b')
            ->select('u, b, c, du, fd, fr')
            ->leftJoin('b.user', 'u')
            ->leftjoin('u.categories', 'c')
            ->leftjoin('u.duties', 'du')
            ->leftjoin('u.followedUsers', 'fd')
            ->leftjoin('u.followers', 'fr')
            ->where("b.chosenCreator = 1")
            ->getQuery();

        return $query->getResult();
    }
}
