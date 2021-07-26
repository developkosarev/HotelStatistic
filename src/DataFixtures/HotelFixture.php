<?php

namespace App\DataFixtures;

use App\Entity\Hotel;
use App\Utils\FakeEntityBuilder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;

class HotelFixture extends Fixture
{
    public const FIXTURE_HOTEL_REFERENCE = 'fixture-hotel';
    public const FIXTURE_HOTEL_STATIC_REFERENCE = 'fixture-hotel-static';
    public const FIXTURE_HOTEL_STATIC_ID = 11;

    public function load(ObjectManager $manager)
    {
        $manager->getClassMetadata(Hotel::class)->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        for ($i = 1; $i <= 10; $i++) {
            $random = substr(md5(rand()), 0, 10);
            $name = sprintf("Hotel %'.03d #%s", $i, $random);

            $fakeProjectBuilder = new FakeEntityBuilder(Hotel::class);
            $hotel = $fakeProjectBuilder
                ->setField('id', $i)
                ->getEntity();

            $hotel->setName($name);
            $manager->persist($hotel);

            $this->addReference(self::FIXTURE_HOTEL_REFERENCE . $i, $hotel);
        }

        $fakeProjectBuilder = new FakeEntityBuilder(Hotel::class);
        $hotelStatic = $fakeProjectBuilder
            ->setField('id', self::FIXTURE_HOTEL_STATIC_ID)
            ->getEntity();

        $hotelStatic->setName('Hotel 011 Static');
        $manager->persist($hotelStatic);

        $this->addReference(self::FIXTURE_HOTEL_STATIC_REFERENCE, $hotelStatic);

        $manager->flush();
    }
}
