<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\SerializedName;

class ReviewStatisticDto
{
    /**
     * @SerializedName("review-count")
     */
    private $reviewCount;

    /**
     * @SerializedName("average-score")
     */
    private $averageScore;

    /**
     * @SerializedName("date-group")
     */
    private $dateGroup;

    public function __construct(int $reviewCount, int $averageScore, string $dateGroup)
    {
        $this->reviewCount = $reviewCount;
        $this->averageScore = $averageScore;
        $this->dateGroup = $dateGroup;
    }

    public function getReviewCount(): int
    {
        return $this->reviewCount;
    }

    public function getAverageScore(): int
    {
        return $this->averageScore;
    }

    public function getDateGroup(): string
    {
        return $this->dateGroup;
    }
}
