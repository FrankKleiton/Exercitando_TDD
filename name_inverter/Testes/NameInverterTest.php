<?php

require __DIR__ . "./../vendor/autoload.php";

use PHPUnit\Framework\TestCase;

class NameInverterTest extends TestCase
{
    /**
     * @test
     */
    public function givenNull_returnsEmptyString(): void
    {
        $this->assertInverted(null, "");
    }

    /**
     * @test
     */
    public function givenEmptyString_returnEmptyString()
    {
        $this->assertInverted("", "");
    }

    /**
     * @test
     */
    public function givenSimpleName_returnSimpleName()
    {
        $this->assertInverted("Franklyn", "Franklyn");
    }

    /**
     * @test
     */
    public function givenNameWithSpace__returnSimpleName()
    {
        $this->assertInverted(" Name ", "Name");
    }

    /**
     * @test
     */
    public function givenFirstLast_returnLastFirst()
    {
        $this->assertInverted("First Last", "Last, First");
    }

    /**
     * @test
     */
    public function givenFirstLastNameWithSpaces_returnLastFirstNameWithoutSpaces()
    {
        $this->assertInverted("  First  Last  ", "Last, First");
    }

    private function assertInverted($originalName, $invertedName)
    {
        return $this->assertEquals($this->invertName($originalName), $invertedName);
    }

    private function invertName($name): string
    {
        if ($name == null || strlen($name) <= 0) {
            return "";
        } else {
            $name = trim(preg_replace('!\s+!', ' ', $name));
            $names = explode(' ', $name);
            if (count($names) == 1)
                return $name;    
            return $names[1].', '.$names[0];
        }
    }
}