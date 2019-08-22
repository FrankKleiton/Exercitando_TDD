<?php

require __DIR__ . "./../vendor/autoload.php";

use PHPUnit\Framework\TestCase;

class SortTest extends TestCase
{
    /**
     * @param array $sorted
     * @return mixed
     */
    private function assertSorted(array $unsorted, array $sorted)
    {
        return $this->assertThat($this->sort($unsorted), $this->equalTo($sorted));
    }

    /**
     * @return array
     */
    private function intArray(int ...$int)
    {
        return $int;
    }

    /**
     * @test
     */
    public function sortings()
    {
        $this->assertSorted($this->intArray(), $this->intArray());
        $this->assertSorted($this->intArray(1), $this->intArray(1));
        $this->assertSorted($this->intArray(2, 1), $this->intArray(1, 2));
        $this->assertSorted($this->intArray(1, 3, 2), $this->intArray(1, 2, 3));
        $this->assertSorted($this->intArray(3, 2, 1), $this->intArray(1, 2, 3));
    }

    private function sort($array)
    {
        for ($size = count($array); $size > 0; $size--)
            for ($index = 0; $size > $index+1; $index++)
                if ($this->outOfOrdem($array, $index))
                    $array = $this->swap($array, $index);

        return $array;
    }

    /**
     * @param $sortedArray
     * @param $index
     * @return mixed
     */
    private function swap($sortedArray, $index)
    {
        $aux = $sortedArray[$index];
        $sortedArray[$index] = $sortedArray[$index + 1];
        $sortedArray[$index + 1] = $aux;
        return $sortedArray;
    }

    /**
     * @param $sortedArray
     * @param $index
     * @return bool
     */
    private function outOfOrdem($sortedArray, $index)
    {
        return $sortedArray[$index] > $sortedArray[$index + 1];
    }
}