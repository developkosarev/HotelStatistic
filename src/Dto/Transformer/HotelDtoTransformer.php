<?php

namespace App\Dto\Transformer;

use App\Dto\HotelDto;

class HotelDtoTransformer extends AbstractDtoTransformer
{
    /**
     * @param $object
     *
     * @return HotelDto
     */
    public function transformFromObject($object): HotelDto
    {
        if (!is_array($object)) {
            throw new UnexpectedTypeException('Expected type of Array but got ' . \get_class($object));
        }

        return new HotelDto($object['id'], $object['name']);
    }
}
