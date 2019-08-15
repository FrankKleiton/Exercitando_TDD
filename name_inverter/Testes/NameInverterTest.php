<?php

require __DIR__ . "./../vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use Testes\NameInverter;

class NameInverterTest extends TestCase
{
    private $nameInverter;

    /**
     * @before
     */
    public function setUpNameInverter()
    {
        $this->nameInverter = new NameInverter();
    }

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
    public function givenEmptyString_returnEmptyString(): void
    {
        $this->assertInverted("", "");
    }

    /**
     * @test
     */
    public function givenSimpleName_returnSimpleName(): void
    {
        $this->assertInverted("Franklyn", "Franklyn");
    }

    /**
     * @test
     */
    public function givenNameWithSpace__returnSimpleName(): void
    {
        $this->assertInverted(" Name ", "Name");
    }

    /**
     * @test
     */
    public function givenFirstLast_returnLastFirst(): void
    {
        $this->assertInverted("First Last", "Last, First");
    }

    /**
     * @test
     */
    public function givenFirstLastNameWithSpaces_returnLastFirstNameWithoutSpaces(): void
    {
        $this->assertInverted("  First  Last  ", "Last, First");
    }

    /**
     * @test
     */
    public function ignoreHonorifics(): void
    {
        // Não viola a regra Triple A - Arrange, Act, Assert uma vez que os dois asserts garantem a veracidade do mesmo teste, lógicamente são um assert. Seria uma violação caso fosse feito um Arrange(Instâncias de váriaveis, objetos ou banco), Act(Função ex: invertName), Assert, Arrange, Act, Assert.
        $this->assertInverted("Mr. First Last", "Last, First");
        $this->assertInverted("Mrs. First Last", "Last, First");
    }

    /**
     * @test
     */
    public function postNominal_stayInTheEnd(): void
    {
        // Isso viola o single assert rule
        $this->assertInverted("First Last Sr.", "Last, First Sr.");
        $this->assertInverted("First Last BS. Phd.", "Last, First BS. Phd.");
    }

    /**
     * @test
     */
    public function integration(): void
    {
        $this->assertInverted("Sr. Franklyn Kleiton II. King.", "Kleiton, Franklyn II. King.");
    }

    private function assertInverted($originalName, $invertedName)
    {
        return $this->assertEquals($this->nameInverter->invertName($originalName), $invertedName);
    }

}