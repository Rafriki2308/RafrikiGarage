<?php

namespace App\Entity;

use App\Repository\WorksheetRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WorksheetRepository::class)
 */
class Worksheet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Car", inversedBy="worksheets")
     * @ORM\JoinColumn (onDelete="SET NULL")
     */
    private $car;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank ()
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Description must be at least {{ limit }} characters long",
     *      maxMessage = "Description cannot be longer than {{ limit }} characters"
     *      )
     */
    private $description;

    /**
     * @param $isActive
     * @param $description
     */
    public function __construct(
        $isActive = true,
        $description=null
    )
    {
        $this->isActive = $isActive;
        $this->description = $description;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar()
    {
        return $this->car;
    }
    
    public function setCar($car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getIsActive():  bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

}
