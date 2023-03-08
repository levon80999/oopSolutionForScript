<?php

declare(strict_types = 1);

namespace App\Services\Parser;

use App\Services\Parser\interface\ParserInterface;

class Parser
{
    /**
     * @var ParserInterface
     */
    private ParserInterface $parser;

    /**
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Set appropriate parser.
     *
     * @param ParserInterface $parser
     * @return void
     */
    public function setParser(ParserInterface $parser): void
    {
        $this->parser = $parser;
    }

    /**
     * @param $data
     * @return array
     */
    public function getResult($data): array
    {
        return $this->parser->parse($data);
    }
}