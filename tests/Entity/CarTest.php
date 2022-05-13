<?php

namespace App\Tests\Entity;

use App\Entity\Car;
use App\Entity\Worksheet;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CarTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    private  Car $car;

    public function __construct()
    {
        parent::__construct();

        $this->validator = self::getContainer()->get(ValidatorInterface::class);
        $this->car = new Car(
            '8554CFB',
            'VSF1ASY1234567890',
            'SEAT',
            'IBIZA',
            'ASY'
        );
    }

    public function test_I_can_create_a_car(): void
    {
        self::assertInstanceOf(Car::class, $this->car);
    }

    public function test_I_can_update_a_regPlate(): void
    {
        $regPlateUpdate = '0092FLK';
        $this->car->setRegPlate($regPlateUpdate);

        self::assertSame($this->car->getRegPlate(), $regPlateUpdate);
    }

    public function test_I_can_update_a_chasisNum(): void
    {
        $chasisNumUpdate = 'WBA001AL71VE22431';
        $this->car->setChasisNum($chasisNumUpdate);

        self::assertSame($this->car->getChasisNum(), $chasisNumUpdate);
    }

    public function test_I_can_update_a_brand(): void
    {
        $brandUpdate = 'BMW';
        $this->car->setChasisNum($brandUpdate);

        self::assertSame($this->car->getChasisNum(), $brandUpdate);
    }

    public function test_I_can_update_a_model(): void
    {
        $modelUpdate = '320D';
        $this->car->setChasisNum($modelUpdate);

        self::assertSame($this->car->getChasisNum(), $modelUpdate);
    }

    public function test_I_can_update_a_engineType(): void
    {
        $engineTypeUpdate = 'M47TU';
        $this->car->setChasisNum($engineTypeUpdate);

        self::assertSame($this->car->getChasisNum(), $engineTypeUpdate);
    }

    public function test_I_can_add_a_worksheet_to_a_car(): void
    {

        $worksheet = new Worksheet(
            true,
            'ChangeTires',
        );

        $worksheets = new ArrayCollection();
        $worksheets->add($worksheet);

        $this->car->setWorksheets($worksheets);

        self::assertSame($this->car->getWorksheets(), $worksheets);
    }

    public function test_I_can_not_create_a_car_with_wrong_regPlate(): void
    {

        $wrongCar1 = new Car(
            '8554',
            'VSF1ASY1234567890',
            'SEAT',
            'IBIZA',
            'ASY'
        );

        $wrongCar2 = new Car(
            '8554C5B',
            'VSF1ASY1234567890',
            'SEAT',
            'IBIZA',
            'ASY'
        );

        $wrongCar = new Car(
            '8554C5B',
            'VSF1ASY1234567890',
            'SEAT',
            'IBIZA',
            'ASY'
        );

        $validationErrors1 = $this->validator->validate($this->car);
        $validationErrors2 = $this->validator->validate($wrongCar1);
        $validationErrors3 = $this->validator->validate($wrongCar2);
        $validationErrors4 = $this->validator->validate($wrongCar);


        self::assertSame(0, $validationErrors1->count());
        self::assertSame(1, $validationErrors2->count());
        self::assertSame(1, $validationErrors3->count());
        self::assertSame(1, $validationErrors4->count());
    }

    public function test_I_can_not_create_a_car_with_wrong_chasisNum(): void
    {
        $wrongCar1 = new Car(
            '8554CFB',
            'VSF1ASY1234',
            'SEAT',
            'IBIZA',
            'ASY'
        );

        $wrongCar2 = new Car(
            '8554CFB',
            'VSF1ASY12345678**',
            'SEAT',
            'IBIZA',
            'ASY'
        );

        $wrongCar3 = new Car(
            '8554CFB',
            '',
            'SEAT',
            'IBIZA',
            'ASY'
        );

        $validationErrors1 = $this->validator->validate($this->car);
        $validationErrors2 = $this->validator->validate($wrongCar1);
        $validationErrors3 = $this->validator->validate($wrongCar2);
        $validationErrors4 = $this->validator->validate($wrongCar3);

        self::assertSame(0, $validationErrors1->count());
        self::assertSame(1, $validationErrors2->count());
        self::assertSame(1, $validationErrors3->count());
        self::assertSame(1, $validationErrors4->count());
    }

}
