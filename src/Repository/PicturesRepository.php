<?php

namespace App\Repository;

use App\Entity\Pictures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pictures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pictures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pictures[]    findAll()
 * @method Pictures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PicturesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pictures::class);
    }

    /**
     * @param string|int $abstractQuery
     * @return int|mixed|string
     */
    public function findPictures(string $abstractQuery = AbstractQuery::HYDRATE_ARRAY)
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->getResult($abstractQuery);
    }
}
