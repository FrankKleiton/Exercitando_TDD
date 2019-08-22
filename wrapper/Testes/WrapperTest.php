<?php

require __DIR__ . './../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class WrapperTest extends TestCase
{

    private function isListOf(int ...$ints)
    {
        return $ints;
    }

    /**
     * @test
     */
    public function factors()
    {
        $this->assertThat($this->primeFactorOf(1), $this->equalTo($this->isListOf()));
        $this->assertThat($this->primeFactorOf(2), $this->equalTo($this->isListOf(2)));
        $this->assertThat($this->primeFactorOf(3), $this->equalTo($this->isListOf(3)));
        $this->assertThat($this->primeFactorOf(4), $this->equalTo($this->isListOf(2, 2)));
        $this->assertThat($this->primeFactorOf(5), $this->equalTo($this->isListOf(5)));
        $this->assertThat($this->primeFactorOf(6), $this->equalTo($this->isListOf(2, 3)));
        $this->assertThat($this->primeFactorOf(7), $this->equalTo($this->isListOf(7)));
        $this->assertThat($this->primeFactorOf(8), $this->equalTo($this->isListOf(2, 2, 2)));
        $this->assertThat($this->primeFactorOf(9), $this->equalTo($this->isListOf(3, 3)));
    }

    private function primeFactorOf(int $n)
    {
        $factors = array();
        for ($divisor = 2; $n > 1; $divisor++)
            for (; $n % $divisor == 0; $n /= $divisor)
                array_push($factors, $divisor);
        return $factors;
    }
}