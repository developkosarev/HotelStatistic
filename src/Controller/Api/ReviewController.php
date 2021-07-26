<?php

namespace App\Controller\Api;

use App\Dto\Transformer\ReviewStatisticDtoTransformer;
use App\Entity\Hotel;
use App\Services\ReviewService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/api/review")
 */
class ReviewController
{
    private $reviewService;

    private $transformer;

    private $serializer;

    public function __construct(
        ReviewService $reviewService,
        ReviewStatisticDtoTransformer $transformer,
        SerializerInterface $serializer
    ) {
        $this->reviewService = $reviewService;
        $this->transformer = $transformer;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/statistic/{id}/{beginDate}/{endDate}", methods={"GET"}, name="statisticReview")
     * @ParamConverter("hotel")
     * @ParamConverter("beginDate", options={"format": "Y-m-d"})
     * @ParamConverter("endDate", options={"format": "Y-m-d"})
     * @param Hotel $hotel
     * @param \DateTime $beginDate
     * @param \DateTime $endDate
     * @return JsonResponse
     */
    public function statistic(Hotel $hotel, \DateTime $beginDate, \DateTime $endDate): JsonResponse
    {
        $statistics = $this->reviewService
            ->getHotelStatistic($hotel, $beginDate, $endDate);

        $reviewStatistics = $this->transformer
            ->transformFromObjects($statistics);

        $data = $this->serializer
            ->serialize($reviewStatistics, 'json');

        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }
}
