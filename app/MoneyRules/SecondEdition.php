<?php

namespace App\MoneyRules;

use App\Exceptions\MoneyException;

class SecondEdition extends AbstractMoneyRules implements IMoneyRules
{
    /**
     * @throws MoneyException
     */
    public function __construct()
    {
        parent::__construct(true);
        $this->addCoin('copper', 'cp', 1, 1 / 50);
        $this->addCoin('silver', 'sp', 10, 1 / 50);
        $this->addCoin('electrum', 'ep', 50, 1 / 50);
        $this->addCoin('gold', 'gp', 100, 1 / 50, true);
        $this->addCoin('platinum', 'pp', 500, 1 / 50);
    }

    public function getName(): string
    {
        return "AD&D 2nd edition";
    }

    public function getReference(): string
    {
        return "Player's Handbook (2e) (1989), p.66";
    }

    public function getWeightRule(): string
    {
        return "Coins (regardless of metal) normally weigh in at 50 to the pound.";
    }
}