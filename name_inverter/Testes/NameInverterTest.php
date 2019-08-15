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
        return $this->assertEquals($this->invertName($originalName), $invertedName);
    }

    private function invertName($name): string
    {
        if ($name == null || strlen($name) <= 0)
            return "";
        else
            return $this->formatName($this->removeHonorifics($this->splitNames($name)));
    }

    /**
     * @param $names
     * @return string
     */
    private function formatName($names): string
    {
        if (count($names) == 1)
            return $names[0];
        return $this->formatMultiElementName($names);
    }

    /**
     * @param array $names
     * @return array
     */
    private function removeHonorifics(array $names): array
    {
        if (count($names) > 1 && $this->isHonorific($names))
            array_splice($names, 0, 1);
        return $names;
    }

    private function splitNames($names): array
    {
        return preg_split('/\s+/', trim($names));
    }

    /**
     * @param $names
     * @return string
     */
    private function formatMultiElementName($names): string
    {
        $postNominals = "";
        if (count($names) > 2)
            $postNominals = $this->getPostNominals($names);
        return trim($names[1] . ', ' . $names[0] . ' ' . $postNominals);
    }

    private function isHonorific($word): bool
    {
        return preg_match('/\./', $word[0]);
    }

    private function getPostNominals($names): string
    {
        $postNominal = "";
        foreach ($this->extractPostNominals($names) as $nominal)
            $postNominal .= $nominal . " ";
        return $postNominal;
    }

    /**
     * @param $names
     * @return array
     */
    private function extractPostNominals($names): array
    {
        $postNominals = [];
        if (count($names) > 3)
            $postNominals = array_slice($names, 2, count($names) - 1);
        else
            $postNominals = array_slice($names, 2);
        return $postNominals;
    }
}