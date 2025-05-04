<?php

namespace App\Foundation\Enums;

trait EnumValueListing
{
    /**
     * @return string[]|int[]
     */
    public static function list(): array
    {
        return array_column(self::cases(), 'value');
    }
}
