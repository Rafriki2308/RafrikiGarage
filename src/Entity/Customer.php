<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as CustomAssert;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 25,
     *      minMessage = "Your name must be at least {{ limit }} characters long",
     *      maxMessage = "Your name cannot be longer than {{ limit }} characters"
     *      )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Length(
     *      min = 2,
     *      max = 150,
     *      minMessage = "Your surname must be at least {{ limit }} characters long",
     *      maxMessage = "Your surname cannot be longer than {{ limit }} characters"
     *      )
     */
    private $surnames;

    /**
     * @ORM\Column(type="string", length=9, unique=true)
     * @Assert\NotBlank()
     * @CustomAssert\ValidIdCard()
     *
     */
    private $idCard;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(
     *      min = 600000000,
     *      max = 699999999,
     *      notInRangeMessage = "The telephone number must be  between {{ min }} and {{ max }}",
     *      )
     */
    private $telNumber;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     * @Assert\NotBlank()
     */
    private $eMail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToMany(targetEntity="Car", mappedBy="customer")
     */
    private $cars;

    /**
     * @param $name
     * @param $surnames
     * @param $idCard
     * @param $telNumber
     * @param $eMail
     */
    public function __construct(
        $name = null,
        $surnames = null,
        $idCard = null,
        $telNumber = null,
        $eMail = null,
        $isActive = true
    )
    {
        $this->name = $name;
        $this->surnames = $surnames;
        $this->idCard = $idCard;
        $this->telNumber = $telNumber;
        $this->eMail = $eMail;
        $this->isActive = $isActive;
        $this->cars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurnames(): ?string
    {
        return $this->surnames;
    }

    public function setSurnames(string $surnames): self
    {
        $this->surnames = $surnames;

        return $this;
    }

    public function getIdCard(): ?string
    {
        return $this->idCard;
    }

    public function setIdCard(string $idCard): self
    {
        $this->idCard = $idCard;

        return $this;
    }

    public function getTelNumber(): ?int
    {
        return $this->telNumber;
    }

    public function setTelNumber(int $telNumber): self
    {
        $this->telNumber = $telNumber;

        return $this;
    }

    public function getEMail(): ?string
    {
        return $this->eMail;
    }

    public function setEMail(?string $eMail): self
    {
        $this->eMail = $eMail;

        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getCars()
    {
        return $this->cars;
    }

    public function setCars(ArrayCollection $cars): void
    {
        $this->cars = $cars;
    }

}
