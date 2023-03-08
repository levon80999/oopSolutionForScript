<?php

declare(strict_types = 1);

/**
 * @param $path
 * @return string
 */
function rootPath($path = '') : string
{
    if (!empty($path) && $path[0] === '/') {
        $path = substr($path, 1);
    } elseif (str_contains($path, 'vfs://')) {
        return $path;
    }

    return  dirname(__FILE__, 3).'/'.$path;
}

/**
 * @param $countryCode
 * @return bool
 */
function isEu($countryCode = ''): bool
{
    return match ($countryCode) {
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK' => true,
        default => false,
    };
}

/**
 * @param string $currency
 * @param float $rate
 * @param float $amount
 * @param bool $isEu
 * @return float
 */
function calculateCommission(string $currency, float $rate, float $amount, bool $isEu): float
{
    $amountFixed = 0;

    try {
        if ($currency === 'EUR' || $rate === 0) {
            $amountFixed = $amount;
        }
        if ($currency !== 'EUR' || $rate > 0) {
            if ($amount > 0) {
                $amountFixed = $amount / $rate;
            }
        }
    } catch (DivisionByZeroError $exception) {
        return 0.000000;
    }

    $result = $amountFixed * ($isEu ? 0.01 : 0.02);
    $format = number_format($result, 2, '.', '');

    return roundFloatUp((float) $format, 2);
}

function roundFloatUp(float $value, $position = 0): float|int
{
    if ($position < 0) {
        $position = 0;
    }
    $multiply = pow(10, $position);

    return ceil($value * $multiply) / $multiply;
}