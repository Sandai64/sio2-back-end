<?php

namespace App\Entity;

use App\Repository\CommandsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandsRepository::class)
 */
class Commands
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $table_number;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_served;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTableNumber(): ?int
    {
        return $this->table_number;
    }

    public function setTableNumber(int $table_number): self
    {
        $this->table_number = $table_number;

        return $this;
    }

    public function getIsServed(): ?bool
    {
        return $this->is_served;
    }

    public function setIsServed(bool $is_served): self
    {
        $this->is_served = $is_served;

        return $this;
    }
}
