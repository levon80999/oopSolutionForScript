<?php

declare(strict_types = 1);

namespace tests;

use App\Services\Parser\JsonParser;
use App\Services\Parser\Parser;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testGetResult_WithValidJson_ReturnsArray()
    {
        $jsonString = '{"bin":"45717360","amount":"100.00","currency":"EUR"}';

        $parser = new Parser(new JsonParser());
        $result = $parser->getResult($jsonString);

        $this->assertEquals('45717360', $result[0]['bin']);
        $this->assertEquals('100.00', $result[0]['amount']);
        $this->assertEquals('EUR', $result[0]['currency']);
    }

    public function testGetResult_WithInValidJson_ReturnsException()
    {
        $this->expectException(InvalidArgumentException::class);

        $jsonString = '{"bin":"45717360","amount":"100.00","currency":"EUR"},';

        $parser = new Parser(new JsonParser());
        $parser->getResult($jsonString);
    }

    public function testGetResult_WithMultiLineJson_ReturnsArray()
    {
        $jsonString = '{"bin":"45717360","amount":"100.00","currency":"EUR"}
        {"bin":"45717360","amount":"100.00","currency":"EUR", "newItem": "III"}';

        $parser = new Parser(new JsonParser());
        $result = $parser->getResult($jsonString);

        $this->assertEquals('45717360', $result[0]['bin']);
        $this->assertEquals('100.00', $result[0]['amount']);
        $this->assertEquals('EUR', $result[0]['currency']);

        $this->assertEquals('45717360', $result[1]['bin']);
        $this->assertEquals('100.00', $result[1]['amount']);
        $this->assertEquals('EUR', $result[1]['currency']);
        $this->assertEquals('III', $result[1]['newItem']);
    }
}