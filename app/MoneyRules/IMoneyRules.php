<?php

namespace App\MoneyRules;

enum ValueType
{
    case Original;
    case OptimalWeight;
    case OptimalGold;
}

interface IMoneyRules
{
    public function coinCount(): int;
    public function getConversionString(string $centered_on = 'gp'): string;
    public function getConversionTable(): array;
    public function getConversionTableColumnHeadings(): array;
    public function getLongNames(): array;
    public function getName(): string;
    public function getReference(): string;
    public function getShortNames(): array;
    public function getValue(ValueType $value_type = ValueType::Original, bool $include_zeros = false): string;
    public function getWeight(ValueType $value_type = ValueType::Original): string;
    public function getWeightRule(): string;
    public function getAmountRegexPattern() : string;
//    public function setCoin(int $value, string $short_name): void;
}
