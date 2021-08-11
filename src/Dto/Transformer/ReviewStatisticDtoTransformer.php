<?php

namespace App\Dto\Transformer;

use App\Dto\ReviewStatisticDto;

class ReviewStatisticDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param $object
     *
     * @return ReviewStatisticDto
     */
    public function transformFromObject($object): ReviewStatisticDto
    {
        if (!is_array($object)) {
            throw new UnexpectedTypeException('Expected type of Array but got ' . \get_class($object));
        }

        $dateGroup = $this->getDateGroup($object);

        return new ReviewStatisticDto($object['reviewCount'], $object['averageScore'], $dateGroup);
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
