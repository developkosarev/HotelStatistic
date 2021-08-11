<?php

namespace App\Tests\Repository;

use App\DataFixtures\HotelFixture;
use App\DataFixtures\ReviewFixture;
use App\Entity\Hotel;
use App\Entity\Review;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReviewRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private static $entityManager;

    /**
     * @var Hotel
     */
    private static $hotel;

    public static function setUpBeforeClass(): void
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $container = $kernel->getContainer();

        self::$entityManager = $container->get('doctrine')->getManager();
        self::$hotel = self::$entityManager->getRepository(Hotel::class)->find(HotelFixture::FIXTURE_HOTEL_STATIC_ID);
    }

    public function testCountRecord()
    {
        $repository = self::$entityManager->getRepository(Review::class);
        $count = $repository->getCountRecords();

        $this->assertEquals(ReviewFixture::REVIEW_COUNT + ReviewFixture::REVIEW_STATIC_COUNT, $count);
    }

    public function testHotelStatisticMonthly()
    {
        $beginDate = new \DateTime('2021-01-01');
        $endDate = new \DateTime('2021-01-28');

        $repository = self::$entityManager->getRepository(Review::class);
        $statistic = $repository->getHotelStatistic(self::$hotel, $beginDate, $endDate);

        $expectedStatistic = [
            0 => [
                'createdMonth' => '1',
                'createdYear' => '2021',
                'averageScore' => '3.0000',
                'score' => '24',
                'reviewCount' => 8
            ]
        ];

        $this->assertEquals($expectedStatistic, $statistic);
    }

    public function testHotelStatisticDaily()
    {
        $beginDate = new \DateTime('2021-01-01');
        $endDate = new \DateTime('2021-01-28');

        $repository = self::$entityManager->getRepository(Review::class);
        $statistic = $repository->getHotelStatistic(self::$hotel, $beginDate, $endDate, Review::DAILY);

        $expectedStatistic = [
            0 => [
                'createdDate' => '2021-01-01',
                'averageScore' => 1.0000,
                'score' => 2,
                'reviewCount' => 2
            ],
            1 => [
                'createdDate' => '2021-01-02',
                'averageScore' => 5.0000,
                'score' => 15,
                'reviewCount' => 3
            ],
            2 => [
                'createdDate' => '2021-01-05',
                'averageScore' => 2.0000,
                'score' => 2,
                'reviewCount' => 1
            ],
            3 => [
                'createdDate' => '2021-01-06',
                'averageScore' => 2.5000,
                'score' => 5,
                'reviewCount' => 2
            ]
        ];

        $this->assertEquals($expectedStatistic, $statistic);
    }
}
