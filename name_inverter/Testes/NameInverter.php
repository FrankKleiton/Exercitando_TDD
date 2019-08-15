<?php

namespace Testes;

use NameInverterTest;

class NameInverter
{

    public function invertName($name): string
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
    public function formatName($names): string
    {
        if (count($names) == 1)
            return $names[0];
        return $this->formatMultiElementName($names);
    }

    /**
     * @param array $names
     * @return array
     */
    public function removeHonorifics(array $names): array
    {
        if (count($names) > 1 && $this->isHonorific($names))
            array_splice($names, 0, 1);
        return $names;
    }

    public function splitNames($names): array
    {
        return preg_split('/\s+/', trim($names));
    }

    /**
     * @param $names
     * @return string
     */
    public function formatMultiElementName($names): string
    {
        $postNominals = "";
        if (count($names) > 2)
            $postNominals = $this->getPostNominals($names);
        return trim($names[1] . ', ' . $names[0] . ' ' . $postNominals);
    }

    public function isHonorific($word): bool
    {
        return preg_match('/\./', $word[0]);
    }

    public function getPostNominals($names): string
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
    public function extractPostNominals($names): array
    {
        $postNominals = [];
        if (count($names) > 3)
            $postNominals = array_slice($names, 2, count($names) - 1);
        else
            $postNominals = array_slice($names, 2);
        return $postNominals;
    }
}