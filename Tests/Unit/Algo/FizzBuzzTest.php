<?php

declare(strict_types=1);

namespace Tests\Unit\Algo;

use Algo\FizzBuzz;
use PHPUnit\Framework\TestCase;

class FizzBuzzTest extends TestCase
{
    /** @var FizzBuzz */
    protected $fizzBuzz;

    public function setUp(): void
    {
        $this->fizzBuzz = new FizzBuzz();
    }

    public function testDisplayException(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Number should be greater or equal than 1');

        $this->fizzBuzz->display(-1);
    }

    /**
     * @param int $number
     * @param string $expected
     * @return void
     * @throws \Exception
     * @dataProvider displayProvider
     */
    public function testDisplay(int $number, string $expected): void
    {
        $this->expectOutputString($expected);
        $this->fizzBuzz->display($number);
    }

    /**
     * @return array[]
     */
    public function displayProvider(): array
    {
        return [
            'Nombre divisible par 3' => [6, 'Fizz'],
            'Nombre divisible par 5' => [10, 'Buzz'],
            'Nombre divisible par 3 et par 5' => [15, 'FizzBuzz'],
            'Nombre non divisible par 3 ou 5' => [22, '22']
        ];
    }
}