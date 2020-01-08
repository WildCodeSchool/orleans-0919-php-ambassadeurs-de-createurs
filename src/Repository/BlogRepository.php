<?php

namespace App\Repository;

use App\Controller\BlogController;
use App\Entity\Blog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Blog|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blog|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blog[]    findAll()
 * @method Blog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blog::class);
    }


    public function findAllSortAndPage(?int $page = null): array
    {

        $query = $this->createQueryBuilder('b')
            ->where('CURRENT_DATE() >= b.date')
            ->orderBy('b.date', 'DESC');

        if ($page !== null) {
            $firstResult = ($page - 1) * BlogController::NB_MAX_ARTICLES;
            $query->setFirstResult($firstResult)->setMaxResults(BlogController::NB_MAX_ARTICLES);
        }

        return $query->getQuery()->getResult();
    }
}
