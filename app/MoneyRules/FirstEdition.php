<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class FirstEdition extends AbstractMoneyRules implements IMoneyRules
{
    /**
     * @throws MoneyException
     */
    public function __construct()
    {
        parent::__construct(true);
        $this->addCoin('copper', 'cp', 1, 1 / 10);
        $this->addCoin('silver', 'sp', 10, 1 / 10);
        $this->addCoin('electrum', 'ep', 100, 1 / 10);
        $this->addCoin('gold', 'gp', 200, 1 / 10, true);
        $this->addCoin('platinum', 'pp', 1000, 1 / 10);
    }

    public function getName(): string
    {
        return "AD&D 1st edition";
    }

    public function getReference(): string
    {
        return "Players Handbook (1e) (1978), p.35";
    }

    public function getWeightRule(): string
    {
        return "Weight is usually stated in golds, 10 golds equalling 1# (pound)";
    }
}