<?php

namespace App\Tests\Services;

use App\Entity\Review;
use App\Services\IntervalService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntervalServiceTest extends KernelTestCase
{
    private static $intervalService;

    public static function setUpBeforeClass(): void
    {
        self::$intervalService = new IntervalService();
    }

    public function testGetInterval()
    {
        $intervals = [
            [new \DateTime('2021-01-01'), new \DateTime('2021-01-01'), Review::DAILY],
            [new \DateTime('2021-01-01'), new \DateTime('2021-01-30'), Review::WEEKLY],
            [new \DateTime('2021-01-01'), new \DateTime('2021-12-31'), Review::MONTHLY],
        ];

        foreach ($intervals as [$beginDate, $endDate, $expectedResult]) {
            $result = self::$intervalService->getInterval($beginDate, $endDate);

            $this->assertEquals($expectedResult, $result);
        }
    }
}
