<?php

namespace App\Support;

class ReferenceGenerator
{
    public static function booking(): string
    {
        return 'BK-' . strtoupper(substr(bin2hex(random_bytes(6)), 0, 10));
    }
}