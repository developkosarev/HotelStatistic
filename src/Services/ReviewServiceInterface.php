<?php

namespace App\Services;

use App\Entity\Hotel;

interface ReviewServiceInterface
{
    public function getHotelStatistic(Hotel $hotel, \DateTime $beginDate, \DateTime $endDate): array;
}
