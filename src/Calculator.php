<?php

declare(strict_types=1);

namespace Unit\Information;

/**
 * @package Unit\Information
 */
final class Calculator
{
    public function add(Size $a, Size $b): Size
    {
        $result = $a->getBits() + $b->get('b');

        if (0 > $result) {
            throw new \OutOfBoundsException('Could not add, the result would be less than 0.');
        }

        $a->setBits(\round($result));

        return $a;
    }

    public function subtract(Size $a, Size $b): Size
    {
        $result = $a->getBits() - $b->get('b');

        if (0 > $result) {
            throw new \OutOfBoundsException('Could not subtract, the result would be less than 0.');
        }

        $a->setBits(\round($result));

        return $a;
    }

    public function multiply(Size $a, Size $b): Size
    {
        $result = $a->getBits() * $b->get('b');

        if (0 > $result) {
            throw new \OutOfBoundsException('Could not multiply, the result would be less than 0.');
        }

        $a->setBits(\round($result));

        return $a;
    }

    public function divide(Size $a, Size $b): Size
    {
        if (0 === $b->get('b')) {
            throw new \OutOfBoundsException('Could not divide by zero.');
        }

        $result = $a->getBits() / $b->get('b');

        if (0 > $result) {
            throw new \OutOfBoundsException('Could not divide, the result would be less than 0.');
        }

        $a->setBits(\round($result));

        return $a;
    }
}
