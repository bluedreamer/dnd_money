<?php

namespace App\MoneyRules;

class FifthEdition extends AbstractMoneyRules implements IMoneyRules
{
    /**
     * @throws \App\Exceptions\MoneyException
     */
    public function __construct()
    {
        parent::__construct(true);
        $this->addCoin('copper', 'cp', 1, 1 / 50);
        $this->addCoin('silver', 'sp', 10, 1 / 50);
        $this->addCoin('electrum', 'ep', 50, 1 / 50);
        $this->addCoin('gold', 'gp', 100, 1 / 50);
        $this->addCoin('platinum', 'pp', 1000, 1 / 50);
    }

    public function getName(): string
    {
        return "D&D 5th Edition";
    }

    public function getReference(): string
    {
        return "Player's Handbook (2014) p.143";
    }

    public function getWeightRule(): string
    {
        return "A standard coin weighs about a third of an ounce, so fifty coins weigh a pound.";
    }

}