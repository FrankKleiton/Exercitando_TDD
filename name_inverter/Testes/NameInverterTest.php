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

    /**
     * @test
     */
    public function ignoreHonorifics()
    {
        // Não viola a regra Triple A - Arrange, Act, Assert uma vez que os dois asserts garantem a veracidade do mesmo teste, lógicamente são um assert. Seria uma violação caso fosse feito um Arrange(Instâncias de váriaveis, objetos ou banco), Act(Função ex: invertName), Assert, Arrange, Act, Assert.
        $this->assertInverted("Mr. First Last", "Last, First");
        $this->assertInverted("Mrs. First Last", "Last, First");
    }

    /**
     * @test
     */
    public function postNominal_stayInTheEnd()
    {
        // Isso viola o single assert rule
        $this->assertInverted("First Last Sr.", "Last, First Sr.");
        $this->assertInverted("First Last BS. Phd.", "Last, First BS. Phd.");
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
            $names = $this->splitNames($name);
            if (count($names) > 1 && $this->isHonorific($names)) {
                array_splice($names, 0, 1);
            }
            if (count($names) == 1) {
                return $names[0];
            } else {
                $postNominals = "";
                if (count($names) > 2)
                    $postNominals = $this->getPostNominals($names);
                return trim($names[1].', '.$names[0].' '.$postNominals);
            }
        }
    }

    private function splitNames($names)
    {
        return preg_split('/\s+/', trim($names));
    }

    private function isHonorific($word)
    {
        return preg_match('/\./', $word[0]);
    }

    private function getPostNominals($names)
    {   $postNominals = [];
        if (count($names) > 3) {
            $postNominals = array_slice($names, 2, count($names)-1);
        } else {
            $postNominals = array_slice($names, 2);
        }
        $postNominal = "";
        foreach ($postNominals as $nominal) {
            $postNominal .= $nominal." ";
        }
        return $postNominal;       
    }
}