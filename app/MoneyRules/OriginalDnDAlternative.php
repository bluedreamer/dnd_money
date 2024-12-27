<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class OriginalDnDAlternative extends AbstractMoneyRules implements IMoneyRules
{
    /**
     * @throws MoneyException
     */
    public function __construct()
    {
        parent::__construct(false);
        $this->addCoin('copper', 'cp', 1);
        $this->addCoin('silver', 'sp', 5);
        $this->addCoin('electrum', 'ep', 25);
        $this->addCoin('gold', 'gp', 50, null, true);
        $this->addCoin('platinum', 'pp', 250);
    }

    public function getName(): string
    {
        return "Original D&D - Alternative";
    }

    public function getReference(): string
    {
        return "Monsters & Treasure (1974), p.39";
    }

    public function getWeightRule(): string
    {
        return "none";
    }
}