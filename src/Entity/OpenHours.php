<?php

namespace App\Entity;

use App\Repository\OpenHoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpenHoursRepository::class)]
class OpenHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $start_hours = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $end_hours = null;

    #[ORM\OneToMany(mappedBy: 'Open_hours', targetEntity: UserOpenHours::class)]
    private Collection $userOpenHours;

    public function __construct()
    {
        $this->userOpenHours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartHours(): ?\DateTimeInterface
    {
        return $this->start_hours;
    }

    public function setStartHours(\DateTimeInterface $start_hours): self
    {
        $this->start_hours = $start_hours;

        return $this;
    }

    public function getEndHours(): ?\DateTimeInterface
    {
        return $this->end_hours;
    }

    public function setEndHours(\DateTimeInterface $end_hours): self
    {
        $this->end_hours = $end_hours;

        return $this;
    }

    /**
     * @return Collection<int, UserOpenHours>
     */
    public function getUserOpenHours(): Collection
    {
        return $this->userOpenHours;
    }

    public function addUserOpenHour(UserOpenHours $userOpenHour): self
    {
        if (!$this->userOpenHours->contains($userOpenHour)) {
            $this->userOpenHours->add($userOpenHour);
            $userOpenHour->setOpenHours($this);
        }

        return $this;
    }

    public function removeUserOpenHour(UserOpenHours $userOpenHour): self
    {
        if ($this->userOpenHours->removeElement($userOpenHour)) {
            // set the owning side to null (unless already changed)
            if ($userOpenHour->getOpenHours() === $this) {
                $userOpenHour->setOpenHours(null);
            }
        }

        return $this;
    }
}
