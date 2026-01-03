<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class BasicSetMoldvay extends AbstractMoneyRules implements IMoneyRules
{
    /**
     * @throws MoneyException
     */
    public function __construct()
    {
        parent::__construct(true);
        $this->addCoin('copper', 'cp', 1, 1 / 40);
        $this->addCoin('silver', 'sp', 10, 1 / 40);
        $this->addCoin('electrum', 'ep', 50, 1 / 40);
        $this->addCoin('gold', 'gp', 100, 1 / 40);
        $this->addCoin('platinum', 'pp', 500, 1 / 40);
    }

    public function getName(): string
    {
        return "Basic D&D (B/X)";
    }

    public function getReference(): string
    {
        return "Basic Set (B/X) (1981), p.47";
    }

    public function getWeightRule(): string
    {
        return "Each coin is about the size and weight of an American half-dollar. (11.34g)";
    }
}