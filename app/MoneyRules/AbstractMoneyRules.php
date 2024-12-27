<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

abstract class AbstractMoneyRules
{
    const oz_in_lb = 16;

    /**
     * @var Coin[] $coin_data
     */
    private array $coin_data                     = [];
    private bool  $has_one_to_one_multiplier_set = false;
    private array $amounts                       = [];

    public function __construct(private bool $has_weights)
    {
    }

    public function coinCount(): int
    {
        $total = 0;
        foreach($this->coin_data as $coin)
        {
            $total += $this->amounts[$coin->short_name];
        }
        return $total;
    }

    /**
     * @throws MoneyException
     */
    public function getAmountRegexPattern(): string
    {
        return sprintf("/\b(\d+)\s*(%s)\b/", implode('|', $this->getShortNames()));
    }

    /**
     * @return string
     * @throws MoneyException
     */
    public function getConversionString(string $centered_on = 'gp'): string
    {
        $this->validate();

        $primary = $this->getCoinByShortName($centered_on);

        $result = '';
        $equals = '';
        foreach($this->coin_data as $coin)
        {
            $result .= $equals;
            if($coin->multiplier > $primary->multiplier)
            {
                $result .= sprintf('1/%d', $coin->multiplier / $primary->multiplier);
            }
            else
            {
                $result .= sprintf('%d', $primary->multiplier / $coin->multiplier);
            }
            $result .= sprintf(" %s", $coin->short_name);

            $equals = ' = ';
        }

        return $result;
    }

    public function getConversionTable(): array
    {
        $result = [];
        foreach($this->coin_data as $coin)
        {
            $row   = &$result[];
            $row[] = sprintf("%s (%s)", ucfirst($coin->long_name), $coin->short_name);
            foreach($this->coin_data as $convert_to)
            {
                if($convert_to->multiplier > $coin->multiplier)
                {
                    $row[] = sprintf('1/%d', $convert_to->multiplier / $coin->multiplier);
                }
                else
                {
                    $row[] = sprintf('%d', $coin->multiplier / $convert_to->multiplier);
                }
            }
        }

        return $result;
    }

    public function getConversionTableColumnHeadings(): array
    {
        $result = ['Coin'];
        foreach($this->coin_data as $coin)
        {
            $result[] = $coin->short_name;
        }
        return $result;
    }

    /**
     * @return array
     * @throws MoneyException
     */
    public function getLongNames(): array
    {
        $this->validate();
        $result = [];
        foreach($this->coin_data as $coin)
        {
            $result[] = $coin->long_name;
        }
        return $result;
    }

    /**
     * @throws MoneyException
     */
    public function getShortNames(): array
    {
        $this->validate();
        $result = [];
        foreach($this->coin_data as $coin)
        {
            $result[] = $coin->short_name;
        }
        return $result;
    }

    /**
     * @throws MoneyException
     */
    public function getValue(ValueType $value_type = ValueType::Original, bool $include_zeros = false): string
    {
        $amounts       = $this->getAmounts($value_type);
        $result        = '';
        $comma         = '';
        $reverse_coins = array_reverse($this->coin_data);

        foreach($reverse_coins as $coin)
        {
            if($include_zeros || $amounts[$coin->short_name] != 0)
            {
                $result .= sprintf("%s%d %s", $comma, $amounts[$coin->short_name], $coin->short_name);
                $comma  = ', ';
            }
        }
        return $result;
    }

    /**
     * @throws MoneyException
     */
    public function getWeight(ValueType $value_type = ValueType::Original): string
    {
        $amounts = $this->getAmounts($value_type);

        if(!$this->has_weights)
        {
            return 'n/a';
        }
        $total_ounces = 0;
        foreach($this->coin_data as $coin)
        {
            $total_ounces += $amounts[$coin->short_name] * ($coin->weight_in_lb * self::oz_in_lb);
        }
        $pounds = intval($total_ounces / self::oz_in_lb);
        return sprintf('%d lb %.2f oz', $pounds, $total_ounces - ($pounds * self::oz_in_lb));
    }

    public function hasWeights(): bool
    {
        return $this->has_weights;
    }

    /**
     * @param int $value
     * @param string $short_name
     * @return void
     * @throws MoneyException
     */
    public function setCoin(int $value, string $short_name): void
    {
        if(!array_key_exists($short_name, $this->amounts))
        {
            throw new MoneyException("$short_name is unknown short name for coins");
        }
        $this->amounts[$short_name] = $value;
    }

    /**
     * @throws MoneyException
     */
    protected function addCoin(string $long_name, string $short_name, int $multiplier, ?float $weight_in_lb = null): void
    {
        if(array_key_exists($multiplier, $this->coin_data))
        {
            throw new MoneyException("Conversion multiplier already exists");
        }
        if($multiplier == 1)
        {
            $this->has_one_to_one_multiplier_set = true;
        }
        $this->coin_data[$multiplier] = new Coin($long_name, $short_name, $multiplier, $weight_in_lb);
        $this->amounts[$short_name]   = 0;
        ksort($this->coin_data);
    }

    /**
     * @throws MoneyException
     */
    private function getAmounts(ValueType $value_type): array
    {
        if($value_type == ValueType::Original)
        {
            return $this->amounts;
        }

        $amounts       = $this->amounts;
        $reverse_coins = array_reverse($this->coin_data);
        $base_coins    = 0;
        foreach($this->coin_data as $coin)
        {
            $base_coins += $amounts[$coin->short_name] * $coin->multiplier;
        }

        switch($value_type)
        {
            case ValueType::OptimalGold:
                $gold_coin = $this->getCoinByShortName('gp');
                foreach($reverse_coins as $coin)
                {
                    $amounts[$coin->short_name] = 0;
                    if($coin->multiplier > $gold_coin->multiplier || $base_coins < $coin->multiplier)
                    {
                        continue;
                    }
                    $value                      = intval($base_coins / $coin->multiplier);
                    $amounts[$coin->short_name] = $value;
                    $base_coins                 -= $value * $coin->multiplier;
                }
            break;
            case ValueType::OptimalWeight:
                foreach($reverse_coins as $coin)
                {
                    $amounts[$coin->short_name] = 0;
                    if($base_coins < $coin->multiplier)
                    {
                        continue;
                    }
                    $value                      = intval($base_coins / $coin->multiplier);
                    $amounts[$coin->short_name] = $value;
                    $base_coins                 -= $value * $coin->multiplier;
                }
            break;
            default:
            break;
        }
        return $amounts;
    }

    /**
     * @throws MoneyException
     */
    private function getCoinByShortName(string $shortname): Coin
    {
        foreach($this->coin_data as $coin)
        {
            if($coin->short_name == $shortname)
            {
                return $coin;
            }
        }
        throw new MoneyException("Cannot find coin $shortname to base conversion string on");
    }

    /**
     * @throws MoneyException
     */
    private function validate(): void
    {
        if(!$this->has_one_to_one_multiplier_set)
        {
            throw new MoneyException("Must have a 1 to 1 coin set");
        }
    }
}