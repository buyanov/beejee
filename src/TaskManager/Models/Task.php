<?php

declare(strict_types=1);

namespace TaskManager\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tasks")
 * @ORM\Entity(repositoryClass="TaskManager\Models\TaskRepository")
 */
class Task extends Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $status;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @var int
     */
    protected $completed;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @var int
     */
    protected $approved;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername($username): void
    {
        $this->username = $username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription($description): void
    {
        $this->description = $description;
    }

    public function setCreated(\DateTime $created): void
    {
        $this->created = $created;
    }

    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setCompleted(bool $completed): void
    {
        $this->completed = (int) $completed;
    }

    public function getCompleted(): bool
    {
        return (bool) $this->completed;
    }

    public function setApproved(bool $approved): void
    {
        $this->approved = (int) $approved;
    }

    public function getApproved(): bool
    {
        return (bool) $this->approved;
    }
}
