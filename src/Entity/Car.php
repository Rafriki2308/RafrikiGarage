<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=7)
     * @CustomAssert\ValidRegPlate(mode="loose")
     */
    private $regPlate;

    /**
     * @ORM\Column(type="string", length=17, unique=true)
     * @CustomAssert\ValidNumChasis(mode="loose")
     */
    private $chasisNum;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length (
     *      min = 2,
     *      max = 100,
     *     minMessage = "Brand must be at least {{ limit }} characters long",
     *     maxMessage = "Brand cannot be longer than {{ limit }} characters"
     *      )
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank()
     * @Assert\Length (
     *      min = 2,
     *      max = 100,
     *     minMessage = "Model must be at least {{ limit }} characters long",
     *     maxMessage = "Model surname cannot be longer than {{ limit }} characters"
     *      )
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     * @Assert\Length (
     *      min = 2,
     *      max = 10,
     *     minMessage = "Engine Type must be at least {{ limit }} characters long",
     *     maxMessage = "Engine Type cannot be longer than {{ limit }} characters"
     *      )
     */
    private $engineType;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please Insert a Valid File")
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $pictureCar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToOne(targetEntity="Customer", inversedBy="car")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $customer;

    /**
     * @ORM\OneToMany(targetEntity="Worksheet", mappedBy="car")
     */
    private $worksheets;

    /**
     * @param $regPlate
     * @param $chasisNum
     * @param $brand
     * @param $model
     * @param $engineType
     */
    public function __construct(
        $regPlate = null,
        $chasisNum = null,
        $brand = null,
        $model = null,
        $engineType = null,
        $pictureCar = null,
        $isActive = true
    )
    {
        $this->regPlate = $regPlate;
        $this->chasisNum = $chasisNum;
        $this->brand = $brand;
        $this->model = $model;
        $this->engineType = $engineType;
        $this->pictureCar = $pictureCar;
        $this->isActive = $isActive;
        $this->worksheets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegPlate(): ?string
    {
        return $this->regPlate;
    }

    public function setRegPlate(string $regPlate): self
    {
        $this->regPlate = $regPlate;

        return $this;
    }

    public function getChasisNum(): ?string
    {
        return $this->chasisNum;
    }

    public function setChasisNum(string $chasisNum): self
    {
        $this->chasisNum = $chasisNum;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getEngineType(): ?string
    {
        return $this->engineType;
    }

    public function setEngineType(string $engineType): self
    {
        $this->engineType = $engineType;

        return $this;
    }

    public function getPictureCar()
    {
        return $this->pictureCar;
    }

    public function setPictureCar($pictureCar): void
    {
        $this->pictureCar = $pictureCar;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }
    
    public function getWorksheets()
    {
        return $this->worksheets;
    }

    public function setWorksheets(ArrayCollection $worksheets): void
    {
        $this->worksheets = $worksheets;
    }

}
