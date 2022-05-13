<?php

namespace App\Tests\Entity;

use App\Entity\Car;
use App\Entity\Customer;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomerTest extends KernelTestCase
{
    private ValidatorInterface $validator;
    private Customer $customer;

    public function __construct()
    {
        parent::__construct();

        $this->validator = self::getContainer()->get(ValidatorInterface::class);
        $this->customer = new Customer(
            'Emmet',
            'Brown',
            '74660189G',
            665649944,
            'Dr.Emmet@correo.es'
        );
    }

    public function test_I_can_create_a_customer(): void
    {


        self::assertInstanceOf(Customer::class, $this->customer);
    }

    public function test_I_can_update_a_name(): void
    {
        $this->customer->setName('Marti');

        self::assertSame($this->customer->getName(), 'Marti');
    }

    public function test_I_can_update_a_surname(): void
    {
        $this->customer->setSurnames('McFly');

        self::assertSame($this->customer->getSurnames(), 'McFly');
    }

    public function test_I_can_update_a_idCard(): void
    {
        $this->customer->setIdCard('24361274Y');

        self::assertSame($this->customer->getIdCard(), '24361274Y');
    }

    public function test_I_can_update_a_telNumber(): void
    {
        $this->customer->setTelNumber(666112233);

        self::assertSame($this->customer->getTelNumber(), 666112233);
    }

    public function test_I_can_update_a_eMail(): void
    {
        $this->customer->setEMail('mcfly@correo.es');

        self::assertSame($this->customer->getEMail(), 'mcfly@correo.es');
    }

    public function test_I_can_add_a_car_to_a_customer(): void
    {

        $car = new Car(
            '8554CFB',
            'VSF1ASY1234567890',
            'SEAT',
            'IBIZA',
            'ASY'
        );

        $cars = new ArrayCollection();
        $cars->add($car);

        $this->customer->setCars($cars);

        self::assertSame($this->customer->getCars(), $cars);
    }

    public function test_I_can_not_create_a_customer_with_a_wrong_idCard(): void
    {
        $wrongCustomer1 = new Customer(
            'Rafael',
            'Martinez',
            '74660189T',
            665649944,
            'rafael@correo.es'
        );

        $wrongCustomer2 = new Customer(
            'Rafael',
            'Martinez',
            '7466T00001',
            665649944,
            'rafael@correo.es'
        );


        $validationErrors1 = $this->validator->validate($this->customer);
        $validationErrors2 = $this->validator->validate($wrongCustomer1);
        $validationErrors3 = $this->validator->validate($wrongCustomer2);

        self::assertSame(0, $validationErrors1->count());
        self::assertSame(1, $validationErrors2->count());
        self::assertSame(2, $validationErrors3->count());
    }

}
