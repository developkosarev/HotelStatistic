<?php

namespace App\Tests\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReviewControllerTest extends WebTestCase
{
    public function testStatistic()
    {
        $client = static::createClient();
        $client->request('GET', '/api/review/statistic/11/2021-01-01/2021-01-28');

        $expectedJson = '
            [
                {
                    "review-count": 2,
                    "average-score": 1,
                    "date-group": "2021-01-01"
                },
                {
                    "review-count": 3,
                    "average-score": 5,
                    "date-group": "2021-01-02"
                },
                {
                    "review-count": 1,
                    "average-score": 2,
                    "date-group": "2021-01-05"
                },
                {
                    "review-count": 2,
                    "average-score": 2,
                    "date-group": "2021-01-06"
                }
            ]
            ';

        $this->assertEquals(JsonResponse::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJsonStringEqualsJsonString($expectedJson, $client->getResponse()->getContent());
    }
}
