<?php

namespace App\Tests\Services;

use App\Entity\Review;
use App\Repository\ReviewRepository;
use App\Services\ReviewService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReviewServiceTest extends KernelTestCase
{
    public function testGetIntervalDaily()
    {
        $reviewService = new ReviewService($this->mockReviewRepositoryRepository());

        $beginDate = new \DateTime('2021-01-01');
        $endDate = new \DateTime('2021-01-01');

        $result = $reviewService->getInterval($beginDate, $endDate);

        $this->assertEquals(Review::DAILY, $result);
    }

    public function testGetIntervalWeekly()
    {
        $reviewService = new ReviewService($this->mockReviewRepositoryRepository());

        $beginDate = new \DateTime('2021-01-01');
        $endDate = new \DateTime('2021-01-30');

        $result = $reviewService->getInterval($beginDate, $endDate);

        $this->assertEquals(Review::WEEKLY, $result);
    }

    public function testGetIntervalMonthly()
    {
        $reviewService = new ReviewService($this->mockReviewRepositoryRepository());

        $beginDate = new \DateTime('2021-01-01');
        $endDate = new \DateTime('2021-12-31');

        $result = $reviewService->getInterval($beginDate, $endDate);

        $this->assertEquals(Review::MONTHLY, $result);
    }

    private function mockReviewRepositoryRepository()
    {
        return $this->createMock(ReviewRepository::class);
    }
}
