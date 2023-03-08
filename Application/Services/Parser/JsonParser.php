<?php

declare(strict_types = 1);

namespace App\Services\Parser;

use App\Services\Parser\interface\ParserInterface;
use InvalidArgumentException;

class JsonParser implements ParserInterface
{
    public function parse($content): array
    {
        $content = explode("\n", $content);

        $result = [];
        foreach ($content as $stringItem) {
            if (!empty($stringItem) && $decoded = json_decode($stringItem, true)) {
                $tmpData = [];
                foreach (json_decode($stringItem, true) as $key => $item) {
                    $tmpData[$key] = $item;
                }
                $result[] = $tmpData;
            } else {
                throw new InvalidArgumentException();
            }
        }

        return $result;
    }
}