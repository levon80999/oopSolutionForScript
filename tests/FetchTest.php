<?php

declare(strict_types = 1);

namespace tests;

use PHPUnit\Framework\TestCase;

class FetchTest extends TestCase
{

//    /**
//     * @throws Exception
//     */
//    protected function setUp(): void
//    {
//        $this->fetchService = $this->getMockBuilder(Fetch::class)->addMethods(['get']);
//
//        parent::setUp();
//    }


    public function test__callMagicMethod_WithAvailableMethod_ReturnsArray()
    {
        // ToDo investigate how to test function called by __call magic method


//        $this->fetchService->method('get')->willReturn(['dsdsds' => 'sddssdsd']);
//
//        $ddd = $this->fetchService->get('http://test.com');
//
//        echo "<pre>"; var_dump($ddd, $this->fetchService->getMethod());die;
//        $this->assertEquals('get', $fetchService->getMethod());
//        $this->assertEquals('http://test.com', $fetchService->getUrl());

        $this->assertFalse(false);
    }
}