<?php

namespace App\DataFixtures;

use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class ReviewFixture extends Fixture
{
    public const REVIEW_COUNT = 100000;
    public const REVIEW_STATIC_COUNT = 8;

    public function load(ObjectManager $manager)
    {
        $this->loadStatic($manager);

        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output, self::REVIEW_COUNT);

        $batchSize = 1000;

        for ($i = 1; $i <= self::REVIEW_COUNT; $i++) {
            if (($i % $batchSize) === 0) {
                $manager->flush();
                $manager->clear();

                $progressBar->advance($batchSize);
            }

            $hotel = rand(1, 10);
            $score = rand(1, 5);
            $comment = substr(md5(rand()), 0, 100);

            $review = new Review();
            $review->setHotel($this->getReference(HotelFixture::FIXTURE_HOTEL_REFERENCE . $hotel))
                ->setScore($score)
                ->setComment($comment)
                ->setCreatedDate($this->dateTimeBetween());

            $manager->persist($review);
        }
        $manager->flush();

        $progressBar->finish();
    }

    private function loadStatic(ObjectManager $manager)
    {
        foreach ($this->getReview() as [$score, $createDate, $comment]) {
            $review = new Review();
            $review->setHotel($this->getReference(HotelFixture::FIXTURE_HOTEL_STATIC_REFERENCE))
                ->setScore($score)
                ->setComment($comment)
                ->setCreatedDate(new \DateTime($createDate));

            $manager->persist($review);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [HotelFixture::class];
    }

    private function getReview(): array
    {
        return [
            [1, '2021-01-01 17:56:43', 'comment1'],
            [1, '2021-01-01 17:56:44', 'comment2'],
            [5, '2021-01-02 17:56:44', 'comment3'],
            [5, '2021-01-02 17:56:45', 'comment4'],
            [5, '2021-01-02 17:56:46', 'comment5'],
            [2, '2021-01-05 00:00:01', 'comment6'],
            [3, '2021-01-06 00:00:01', 'comment7'],
            [2, '2021-01-06 00:00:02', 'comment8'],
        ];
    }

    private function dateTimeBetween($startDate = '-2 years', $endDate = 'now'): \DateTime
    {
        $startTimestamp = $startDate instanceof \DateTime ? $startDate->getTimestamp() : strtotime($startDate);
        $endTimestamp = $this->getMaxTimestamp($endDate);

        if ($startTimestamp > $endTimestamp) {
            throw new \InvalidArgumentException('Start date must be anterior to end date.');
        }

        $timestamp = mt_rand($startTimestamp, $endTimestamp);

        return new \DateTime('@' . $timestamp);
    }

    private function getMaxTimestamp($max = 'now')
    {
        if (is_numeric($max)) {
            return (int) $max;
        }

        if ($max instanceof \DateTime) {
            return $max->getTimestamp();
        }

        return strtotime(empty($max) ? 'now' : $max);
    }
}
