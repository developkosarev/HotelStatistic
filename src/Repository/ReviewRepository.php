<?php

namespace App\Repository;

use App\Entity\Hotel;
use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

class ReviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function getCountRecords(): int
    {
        $query = $this->createQueryBuilder('r')
            ->select('COUNT(r.id)')
            ->getQuery();

        try {
            return $query->getSingleScalarResult();
        } catch (NoResultException | NonUniqueResultException $e) {
            return 0;
        }
    }

    public function getHotelStatistic(Hotel $hotel, \DateTime $beginDate, \DateTime $endDate, string $groupBy = Review::MONTHLY)
    {
        $queryBuilder = $this->createQueryBuilder('r');

        switch ($groupBy) {
            case Review::DAILY:
                $queryBuilder
                    ->select('DATE(r.createdDate) AS createdDate')
                    ->groupBy('createdDate');
                break;
            case Review::WEEKLY:
                $queryBuilder
                    ->select('WEEK(r.createdDate) AS createdWeek, YEAR(r.createdDate) AS createdYear')
                    ->groupBy('createdWeek, createdYear');
                break;
            default:
                $queryBuilder
                    ->select('MONTH(r.createdDate) AS createdMonth, YEAR(r.createdDate) AS createdYear')
                    ->groupBy('createdMonth, createdYear');
                break;
        }

        $queryBuilder
            ->addSelect('AVG(r.score) AS averageScore, SUM(r.score) AS score, COUNT(r.id) AS reviewCount')
            ->andWhere('r.hotel = :hotel')
            ->andWhere('r.createdDate >= :beginDate')
            ->andWhere('r.createdDate < :endDate')
            ->setParameter('hotel', $hotel)
            ->setParameter('beginDate', $beginDate->format('Y-m-d'))
            ->setParameter('endDate', $endDate->modify('+1 day')->format('Y-m-d'));

        return $queryBuilder->getQuery()->getResult();
    }
}
