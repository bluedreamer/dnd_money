<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class DnD2024 extends AbstractMoneyRules implements IMoneyRules
{
    /**
     * @throws MoneyException
     */
    public function __construct()
    {
        parent::__construct(true);
        $this->addCoin('copper', 'cp', 1, 1 / 50, false);
        $this->addCoin('silver', 'sp', 10, 1 / 50, false);
        $this->addCoin('electrum', 'ep', 50, 1 / 50, false);
        $this->addCoin('gold', 'gp', 100, 1 / 50, true);
        $this->addCoin('platinum', 'pp', 1000, 1 / 50, false);
    }

    public function getName(): string
    {
        return "D&D 5th Edition (2024)";
    }

    public function getReference(): string
    {
        return "Player's Handbook (2024) p.213";
    }

    public function getWeightRule(): string
    {
        return "A coin weighs about a third of an ounce, so fifty coins weigh a pound.";
    }

}