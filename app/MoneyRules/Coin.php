<?php

namespace App\MoneyRules;

class Coin
{
    public function __construct(public string $long_name,
                                public string $short_name,
                                public int    $multiplier,
                                public ?float $weight_in_lb = null)
    {
    }
}