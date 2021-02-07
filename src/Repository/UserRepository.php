<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

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
     * @param string|int $abstractQuery
     * @return int|mixed|string
     */
    public function findUsers(string $abstractQuery = AbstractQuery::HYDRATE_ARRAY)
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult($abstractQuery);
    }

    /**
     * @param int $userId
     * @param string|int $abstractQuery
     * @return int|mixed|string
     * @throws NonUniqueResultException
     */
    public function findUserById(int $userId, string $abstractQuery = AbstractQuery::HYDRATE_ARRAY)
    {
        return $this->createQueryBuilder('p')
            ->where('p.id=:id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->getOneOrNullResult($abstractQuery);
    }


}
