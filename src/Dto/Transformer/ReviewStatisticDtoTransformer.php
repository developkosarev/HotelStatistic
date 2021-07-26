<?php

namespace App\Dto\Transformer;

use App\Dto\ReviewStatisticDto;

class ReviewStatisticDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param $statistic
     *
     * @return ReviewStatisticDto
     */
    public function transformFromObject($statistic): ReviewStatisticDto
    {
        if (!is_array($statistic)) {
            throw new UnexpectedTypeException('Expected type of Array but got ' . \get_class($statistic));
        }

        $dateGroup = $this->getDateGroup($statistic);

        return new ReviewStatisticDto($statistic['reviewCount'], $statistic['averageScore'], $dateGroup);
    }

    private function getDateGroup(array $statistic): string
    {
        if (isset($statistic['createdMonth'])) {
            $dateGroup = $statistic['createdYear'] . '-' . $statistic['createdMonth'];
        } elseif (isset($statistic['createdWeek'])) {
            $dateGroup = $statistic['createdYear'] . '-' . $statistic['createdWeek'];
        } else {
            $dateGroup = $statistic['createdDate'];
        }

        return $dateGroup;
    }
}
