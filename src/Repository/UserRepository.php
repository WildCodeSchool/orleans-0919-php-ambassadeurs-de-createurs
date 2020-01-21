<?php

namespace App\Repository;

use App\Controller\SearchController;
use App\Data\SearchData;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }


    public function findSearch(array $search, ?int $page = null): array
    {

        $query = $this->createQueryBuilder('u')
            ->select(['u', 'b', 'fd', 'fr', 's'])
            ->leftjoin('u.brand', 'b')
            ->leftjoin('u.followedUsers', 'fd')
            ->leftjoin('u.followers', 'fr')
            ->join('u.duties', 's');

        if (!empty($search['roles'])) {
            $query->andWhere('u.roles LIKE :roles')
                ->setParameter('roles', '%' . User::ROLES_URL[$search['roles']] . '%')
                ->orderBy('u.firstname', 'ASC');
        }

        if (!empty($search['filters']['department'])) {
            $query->join('u.department', 'd')
                ->andWhere('d.id = :department')
                ->setParameter('department', $search['filters']['department']);
        }

        if (!empty($search['filters']['category'])) {
            $query->join('u.categories', 'c')
                ->andWhere('c.id = :category')
                ->setParameter('category', $search['filters']['category']);
        }

        if (!empty($search['filters']['duty'])) {
            $query->andWhere('s.id = :duty')
                ->setParameter('duty', $search['filters']['duty']);
        }

        if ($page !== null) {
            $firstResult = ($page - 1) * SearchController::NB_MAX_RESULT;
            $query->setFirstResult($firstResult)->setMaxResults(SearchController::NB_MAX_RESULT);
        }


        return $query->getQuery()->getResult();
    }


    public function findByRoles(string $roles): array
    {
        $query = $this->createQueryBuilder('u')
            ->select(['u', 'b', 'c', 'd', 'e', 'fd', 'fr', 'du', 'eb'])
            ->leftjoin('u.brand', 'b')
            ->leftjoin('u.categories', 'c')
            ->leftjoin('u.department', 'd')
            ->leftjoin('u.events', 'e')
            ->leftjoin('e.brand', 'eb')
            ->leftjoin('u.followedUsers', 'fd')
            ->leftjoin('u.followers', 'fr')
            ->leftjoin('u.duties', 'du')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%' . $roles . '%')
            ->getQuery();
        return $query->getResult();
    }

    public function findByMostFavorites(string $roles): array
    {
        $query = $this->createQueryBuilder('u')
            ->select('u')
            ->leftjoin('u.followers', 'fr')
            ->leftjoin('u.events', 'e')
            ->where('u.roles LIKE :roles')
            ->groupBy('u')
            ->addOrderBy('COUNT(fr)', 'DESC')
            ->addOrderBy('COUNT(e)', 'DESC')
            ->setParameter('roles', '%' . $roles . '%')
            ->setMaxResults(6)
            ->getQuery();
        return $query->getResult();
    }
}
