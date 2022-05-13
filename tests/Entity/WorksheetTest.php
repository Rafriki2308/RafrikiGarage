<?php

namespace App\Tests\Entity;

use App\Entity\Worksheet;
use PHPUnit\Framework\TestCase;

class WorksheetTest extends TestCase
{
    private $worksheet;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct();
        $this->worksheet = new Worksheet(
            true,
            'change Tires'
        );
    }

    public function can_I_create_a_worksheet(): void
    {
        self::assertInstanceOf(Worksheet::class, $this->worksheet);
    }

    public function test_I_can_update_if_isActive(): void
    {
        $this->worksheet->setIsActive(false);

        self::assertSame($this->worksheet->getIsActive(), false);
    }

    public function test_I_can_update_a_description(): void
    {
        $description = 'Repair and paint front right door';
        $this->worksheet->setDescription($description);

        self::assertSame($this->worksheet->getDescription(), $description);
    }

}
