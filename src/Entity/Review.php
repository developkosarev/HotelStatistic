<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 * @ORM\Table(name="review",indexes={@ORM\Index(columns={"hotel_id", "created_date"})})
 *
 */
class Review
{
    public const DAILY = 'DAILY';
    public const WEEKLY = 'WEEKLY';
    public const MONTHLY = 'MONTHLY';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Hotel
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel")
     * @ORM\JoinColumn(name="hotel_id", nullable=false)
     */
    private $hotel;

    /**
     * @ORM\Column(type="integer", nullable=false, name="score")
     */
    private $score;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime", name="created_date", nullable=false)
     */
    private $createdDate;

    public function __construct()
    {
        $this->createdDate = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHotel(): Hotel
    {
        return $this->hotel;
    }

    public function setHotel(Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedDate(): \DateTime
    {
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTime $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }
}
