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

        $query = $this->createQueryBuilder('u');

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
            $query->join('u.duties', 's')
                ->andWhere('s.id = :duty')
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
//        $query = $this->createQueryBuilder('r')
//            ->select('u')
//            ->from(User::class, 'u')
//            ->leftjoin('u.brand', 'b')
//            ->leftjoin('u.categories', 'c')
//            ->leftjoin('u.department', 'd')
//            ->leftjoin('u.events', 'e')
//            ->leftjoin('u.followedUsers', 'fd')
//            ->leftjoin('u.followers', 'fr')
//            ->leftjoin('u.duties', 'du')
//            ->where('u.roles LIKE :roles')
//            ->setParameter('roles', '%' . $roles . '%');
//        return $query->getQuery()->getResult();

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT u, b, c, d, e, fd, fr, du
                   FROM App\Entity\User u 
                   LEFT JOIN u.brand b 
                   LEFT JOIN u.categories c
                   LEFT JOIN u.department d
                   LEFT JOIN u.events e
                   LEFT JOIN u.followedUsers fd
                   LEFT JOIN u.followers fr
                   LEFT JOIN u.duties du
                   WHERE u.roles LIKE :roles'
        );
        $query->setParameter('roles', '%' . $roles . '%');
        return $query->execute();
    }
}
