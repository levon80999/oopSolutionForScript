<?php

declare(strict_types = 1);

namespace tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use function dirname;
use function rootPath;
use function isEu;
use function calculateCommission;

class UtilitiesTest extends TestCase
{
    public function testRootPath_WithPathParam_ReturnPathFromRootDir(): void
    {
        $path = rootPath('path');

        $this->assertEquals(dirname(__FILE__, 2).'/path', $path);
    }

    public function testRootPath_WithoutPathParam_ReturnPathFromRootDir(): void
    {
        $path = rootPath('');

        $this->assertEquals(dirname(__FILE__, 2).'/', $path);
    }

    public function testRootPath_WithSlashPathParam_ReturnPathFromRootDir(): void
    {
        $path = rootPath('/path');

        $this->assertEquals(dirname(__FILE__, 2).'/path', $path);
    }

    public function testIsEu_WithEuCountyCode_ReturnTrue()
    {
        $isEu = isEu('BG');

        $this->assertTrue($isEu);
    }

    public function testIsEu_WithNoEuCountyCode_ReturnTrue()
    {
        $isEu = isEu('AM');

        $this->assertFalse($isEu);
    }

    public function testIsEu_WithoutCountyCode_ReturnTrue()
    {
        $isEu = isEu('');

        $this->assertFalse($isEu);
    }

    public function testCalculateCommission_WithAllArgumentsInEU_ReturnFloatNumber()
    {
        $result = calculateCommission('EUR', 1, 100.00, true);

        $this->assertEquals(1, $result);
    }

    public function testCalculateCommission_WithAllArgumentsNotEu_ReturnFloatNumber()
    {
        $result = calculateCommission('EUR', 1, 100.00, false);

        $this->assertEquals(2, $result);
    }

    public function testCalculateCommission_WithZeroArgumentsAndEUR_ReturnFloatNumber()
    {
        $result = calculateCommission('EUR', 0, 100.00, true);

        $this->assertEquals(1.0, $result);
    }

    public function testCalculateCommission_WithZeroArgumentsAndUSD_ReturnFloatNumber()
    {
        $result = calculateCommission('USD', 0, 100.00, true);

        $this->assertEquals('0.000000', $result);
    }

    public function testCalculateCommission_WithFloatRate_ReturnFloatNumber()
    {
        $result = calculateCommission('USD', 1.76234, 100.00, true);

        $this->assertEquals(0.57, $result);
    }

    public function testRoundFloatUp_WithInteger_ReturnInteger()
    {
        $result = roundFloatUp(1, 2);

        $this->assertEquals(1, $result);
    }

    public function testRoundFloatUp_WithZeroInteger_ReturnInteger()
    {
        $result = roundFloatUp(0, 2);

        $this->assertEquals(0, $result);
    }

    public function testRoundFloatUp_WithRoundedFloat_ReturnRoundedFloat()
    {
        $result = roundFloatUp(1.50, 2);

        $this->assertEquals(1.50, $result);
    }

    public function testRoundFloatUp_WithNotRoundedFloat_ReturnRoundedFloat()
    {
        $result = roundFloatUp(1.567543, 2);

        $this->assertEquals(1.57, $result);
    }

    public function testRoundFloatUp_WithWoundingInFirstPosition_ReturnRoundedFloat()
    {
        $result = roundFloatUp(1.567543, 1);

        $this->assertEquals(1.6, $result);
    }
}