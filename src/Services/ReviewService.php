<?php

namespace App\Services;

use App\Entity\Hotel;
use App\Entity\Review;
use App\Repository\ReviewRepository;

class ReviewService
{
    private $repository;

    public function __construct(ReviewRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getHotelStatistic(Hotel $hotel, \DateTime $beginDate, \DateTime $endDate): array
    {
        $interval = $this->getInterval($beginDate, $endDate);

        return $this->repository->getHotelStatistic($hotel, $beginDate, $endDate, $interval);
    }

    public function getInterval(\DateTime $beginDate, \DateTime $endDate): string
    {
        $day = $beginDate->diff($endDate)->days;
        $day++;

        if ($day > 89) {
            return Review::MONTHLY;
        } elseif ($day > 29) {
            return Review::WEEKLY;
        } else {
            return Review::DAILY;
        }
    }
}
