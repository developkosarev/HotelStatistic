<?php

namespace App\Services;

use App\Entity\Review;

class IntervalService implements IntervalServiceInterface
{
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