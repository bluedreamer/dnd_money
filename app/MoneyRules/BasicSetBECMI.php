<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class BasicSetBECMI extends AbstractMoneyRules implements IMoneyRules
{
    /**
     * @throws MoneyException
     */
    public function __construct()
    {
        parent::__construct(true);
        $this->addCoin('copper', 'cp', 1, 1 / 10);
        $this->addCoin('silver', 'sp', 10, 1 / 10);
        $this->addCoin('electrum', 'ep', 50, 1 / 10);
        $this->addCoin('gold', 'gp', 100, 1 / 10);
        $this->addCoin('platinum', 'pp', 500, 1 / 10);
    }

    public function getName(): string
    {
        return "Basic Rules (BECMI)";
    }

    public function getReference(): string
    {
        return "Basic Rules (BECMI) (1983), p.11";
    }

    public function getWeightRule(): string
    {
        return "One coin of treasure, whatever the type (gp, ep, and so forth) weighs about 1/10 of a pound.";
    }
}