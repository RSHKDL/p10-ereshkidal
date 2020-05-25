<?php

namespace App\Entity;

use App\Repository\AbstractReportRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=AbstractReportRepository::class)
 * @ORM\Table(name="app_reports")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="subject", type="string")
 * @ORM\DiscriminatorMap({
 *      "article"="ArticleReport",
 * })
 */
Abstract class AbstractReport
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_RESOLVED = 'resolved';

    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $specificMotive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * AbstractReport constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->name = bin2hex(random_bytes(5));
        $this->status = self::STATUS_PENDING;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getMotive(): ?string
    {
        return $this->motive;
    }

    public function setMotive(?string $motive): self
    {
        $this->motive = $motive;

        return $this;
    }

    public function getSpecificMotive(): ?string
    {
        return $this->specificMotive;
    }

    public function setSpecificMotive(?string $specificMotive): self
    {
        $this->specificMotive = $specificMotive;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function markAsResolved(): void
    {
        $this->status = self::STATUS_RESOLVED;
    }
}
