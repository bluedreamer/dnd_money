<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class FourthEdition extends AbstractMoneyRules
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
        $this->addCoin('platinum', 'pp', 10000, 1 / 50);
        $this->addCoin('astral diamond', 'ad', 1000000, 1 / 500);
    }

    public function getName(): string
    {
        return "D&D 4th edition";
    }

    public function getReference(): string
    {
        return "Player's Handbook (4e) (2008), p.212";
    }

    public function getWeightRule(): string
    {
        return "A coin is about an inch across, and weighs about a third of an ounce (50 coins to the pound). An astral diamond weighs one-tenth as much as a coin
(500 astral diamonds weigh 1 pound).";
    }
}