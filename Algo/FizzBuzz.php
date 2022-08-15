<?php

declare(strict_types=1);

namespace Algo;

class FizzBuzz
{
    /**
     * @param int $number
     * @return int|string
     * @throws \Exception
     */
    public function display(int $number): void
    {
        if (1 > $number) {
           throw new \Exception('Number should be greater or equal than 1');
        }

        if (0 !== $number % 3 && 0 != $number % 5) {
            echo $number;

            return;
        }

        $result = '';

        if (0 === $number % 3) {
            $result .= 'Fizz';
        }

        if (0 === $number % 5) {
            $result .= 'Buzz';
        }

        echo $result;
    }
}