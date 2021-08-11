<?php

namespace App\Services;

use App\Entity\Hotel;
use App\Repository\ReviewRepository;

class ReviewService implements ReviewServiceInterface
{
    private $repository;

    private $intervalService;

    public function __construct(ReviewRepository $repository, IntervalServiceInterface $intervalService)
    {
        $this->repository = $repository;
        $this->intervalService = $intervalService;
    }

    public function getHotelStatistic(Hotel $hotel, \DateTime $beginDate, \DateTime $endDate): array
    {
        $interval = $this->intervalService->getInterval($beginDate, $endDate);

        return $this->repository->getHotelStatistic($hotel, $beginDate, $endDate, $interval);
    }
}
