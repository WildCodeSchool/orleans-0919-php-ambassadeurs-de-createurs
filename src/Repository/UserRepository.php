<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
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
            $query->join('u.duties', 's')
                ->andWhere('s.id = :duty')
                ->setParameter('duty', $search['duty']);
        }
        return $query->getQuery()->getResult();
    }

    public function findByRoles(string $roles) : array
    {
        $query = $this->createQueryBuilder('r')
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%' . $roles . '%');
        return $query->getQuery()->getResult();
    }
}
