<?php

declare(strict_types = 1);

namespace App\Services\Parser;

use App\Services\Parser\interface\ParserInterface;

class XmlParser implements ParserInterface
{
    public function parse($content): array
    {
        // ToDo add parse logic
        return [];
    }
}