<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @param string|int $abstractQuery
     * @return int|mixed|string
     */
    public function findReservations(string $abstractQuery = AbstractQuery::HYDRATE_ARRAY)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('admin')
            ->leftJoin('p.admin', 'admin')
            ->getQuery()
            ->getResult($abstractQuery);
    }

    /**
     * @param string $date
     * @param string|int $abstractQuery
     * @return int|mixed|string
     */
    public function findReservationsByDate(string $date, string $abstractQuery = AbstractQuery::HYDRATE_ARRAY)
    {
        return $this->createQueryBuilder('p')
            ->addSelect('admin')
            ->leftJoin('p.admin', 'admin')
            ->where('p.reservationDate>=:startDate')
            ->setParameter('startDate', $date . ' 00:00:01')
            ->andWhere('p.reservationDate<=:endDate')
            ->setParameter('endDate', $date . ' 23:59:59')
            ->getQuery()
            ->getResult($abstractQuery);
    }
}
