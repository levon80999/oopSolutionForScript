<?php

declare(strict_types = 1);

namespace App\Services\Parser\interface;

interface ParserInterface
{
    /**
     * @param $content
     * @return mixed
     */
    public function parse($content): array;
}