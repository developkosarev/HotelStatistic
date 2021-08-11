<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\SerializedName;

class HotelDto
{
    /**
     * @SerializedName("id")
     */
    private $id;

    /**
     * @SerializedName("name")
     */
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
