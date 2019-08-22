<?php

use PHPUnit\Framework\TestCase;

class PrimeFactorTest extends TestCase
{
    /**
     * @test
     */
    public function canFactorIntoPrimes()
    {

        $this->assertPrimeFactors($this->array(), 1);
        $this->assertPrimeFactors($this->array(2), 2);
        $this->assertPrimeFactors($this->array(3), 3);
        $this->assertPrimeFactors($this->array(2, 2), 4);
        $this->assertPrimeFactors($this->array(5), 5);
        $this->assertPrimeFactors($this->array(2, 3), 6);
        $this->assertPrimeFactors($this->array(7), 7);
        $this->assertPrimeFactors($this->array(2, 2, 2), 8);
        $this->assertPrimeFactors($this->array(3, 3), 9);
        $this->assertPrimeFactors($this->array(2, 2, 3, 3, 5, 7, 11, 13), 2*2*3*3*5*7*11*13);
    }

    /**
     * @param int[] $integer
     * @return array
     */
    private function array(int ...$integer): array
    {
        return $integer;
    }

    private function of(int $n)
    {
        $factors = array();

        for ($divisor = 2; $n > 1; $divisor++)
            for (; $n % $divisor == 0; $n /= $divisor)
                array_push($factors, $divisor);

        return $factors;
    }

    /**
     * @param array $primeFactor
     * @param int $n
     */
    private function assertPrimeFactors(array $primeFactor, int $n): void
    {
        $this->assertEquals($primeFactor, $this->of($n));
    }
}