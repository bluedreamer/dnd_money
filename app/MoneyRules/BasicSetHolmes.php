<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class BasicSetHolmes extends AbstractMoneyRules implements IMoneyRules
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
        $this->addCoin('gold', 'gp', 50, null);
        $this->addCoin('platinum', 'pp', 250);
    }

    public function getName(): string
    {
        return "Basic D&D (Holmes)";
    }

    public function getReference(): string
    {
        return "Basic Set (Holmes) (1977), p.33";
    }

    public function getWeightRule(): string
    {
        return "none";
    }
}