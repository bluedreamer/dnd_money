<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class ThirdEdition_3 extends AbstractMoneyRules
{
    /**
     * @throws MoneyException
     */
    public function __construct()
    {
        parent::__construct(true);
        $this->addCoin('copper', 'cp', 1, 1 / 50);
        $this->addCoin('silver', 'sp', 10, 1 / 50);
        $this->addCoin('gold', 'gp', 100, 1 / 50);
        $this->addCoin('platinum', 'pp', 1000, 1 / 50);
    }

    public function getName(): string
    {
        return "AD&D 3rd edition";
    }

    public function getReference(): string
    {
        return "Player's Handbook (3.0) (2000), p.96";
    }

    public function getWeightRule(): string
    {
        return "The standard coin weighs about a third of an ounce (fifty to the pound).";
    }
}