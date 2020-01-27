<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use IntlDateFormatter;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findMapInfoEvents()
    {

        $qb = $this->createQueryBuilder('e');
        $query = $qb
            ->select('e, u, b, c')
            ->leftjoin('e.user', 'u')
            ->leftjoin('e.brand', 'b')
            ->leftjoin('u.categories', 'c')
            ->where($qb->expr()->gt('e.dateTime', 'CURRENT_TIMESTAMP()'))
            ->getQuery();
        $dataEvents = $query->getResult();
        $events = [];
        foreach ($dataEvents as $key => $dataEvent) {
            $events[$key]['description'] = $dataEvent->getDescription();
            $events[$key]['city'] = $dataEvent->getPlace();
            $events[$key]['date'] = IntlDateFormatter::formatObject(
                $dataEvent->getDateTime(),
                'cccc dd LLLL yyyy',
                'fr_FR'
            );
            $events[$key]['time'] = IntlDateFormatter::formatObject(
                $dataEvent->getDateTime(),
                'HH:mm:ss',
                'fr_FR'
            );
            $events[$key]['host'] = $dataEvent->getUser()->getFirstname();
            $events[$key]['category'] = $dataEvent->getUser()->getCategoriesToString();
            $events[$key]['id'] = $dataEvent->getUser()->getId();
            $events[$key]['latitude'] = $dataEvent->getLatitude();
            $events[$key]['longitude'] = $dataEvent->getLongitude();
        }
        return $events;
    }
}
