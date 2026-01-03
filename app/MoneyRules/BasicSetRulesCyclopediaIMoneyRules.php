<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class BasicSetRulesCyclopediaIMoneyRules extends AbstractMoneyRules
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
        return "Basic Rules (Rules Cyclopedia)";
    }

    public function getReference(): string
    {
        return "Rules Cyclopedia (1991), p.62,";
    }

    public function getWeightRule(): string
    {
        return "One coin weighs one-tenth of a pound.";
    }
}