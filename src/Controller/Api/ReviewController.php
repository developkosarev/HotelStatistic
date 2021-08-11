<?php

namespace App\Controller\Api;

use App\Dto\Transformer\DtoTransformerInterface;
use App\Entity\Hotel;
use App\Services\ReviewServiceInterface;
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

    private $reviewStatisticDtoTransformer;

    private $serializer;

    public function __construct(
        ReviewServiceInterface $reviewService,
        DtoTransformerInterface $reviewStatisticDtoTransformer,
        SerializerInterface $serializer
    ) {
        $this->reviewService = $reviewService;
        $this->reviewStatisticDtoTransformer = $reviewStatisticDtoTransformer;
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

        $reviewStatistics = $this->reviewStatisticDtoTransformer
            ->transformFromObjects($statistics);

        $data = $this->serializer
            ->serialize($reviewStatistics, 'json');

        return new JsonResponse($data, JsonResponse::HTTP_OK, [], true);
    }
}
