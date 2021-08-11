<?php

namespace App\Services;

interface IntervalServiceInterface
{
    public function getInterval(\DateTime $beginDate, \DateTime $endDate): string;
}