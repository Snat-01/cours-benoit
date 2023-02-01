<?php

namespace App\Entity;

use App\Repository\UserOpenHoursRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserOpenHoursRepository::class)]
class UserOpenHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userOpenHours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'userOpenHours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OpenHours $Open_hours = null;

    #[ORM\Column]
    private ?bool $isBooked = null;

    #[ORM\ManyToOne(inversedBy: 'userOpenHoursBooked')]
    private ?User $user_has_booked = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getOpenHours(): ?OpenHours
    {
        return $this->Open_hours;
    }

    public function setOpenHours(?OpenHours $Open_hours): self
    {
        $this->Open_hours = $Open_hours;

        return $this;
    }

    public function isIsBooked(): ?bool
    {
        return $this->isBooked;
    }

    public function setIsBooked(bool $isBooked): self
    {
        $this->isBooked = $isBooked;

        return $this;
    }

    public function getUserHasBooked(): ?User
    {
        return $this->user_has_booked;
    }

    public function setUserHasBooked(?User $user_has_booked): self
    {
        $this->user_has_booked = $user_has_booked;

        return $this;
    }
}
