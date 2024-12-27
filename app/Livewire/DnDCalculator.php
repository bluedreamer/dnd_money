<?php

namespace App\Livewire;

use App\MoneyRules\BasicSetBECMI;
use App\MoneyRules\BasicSetHolmes;
use App\MoneyRules\BasicSetMoldvay;
use App\MoneyRules\BasicSetRulesCyclopediaIMoneyRules;
use App\MoneyRules\DnD2024;
use App\MoneyRules\FifthEdition;
use App\MoneyRules\FirstEdition;
use App\MoneyRules\FourthEdition;
use App\MoneyRules\IMoneyRules;
use App\MoneyRules\OriginalDnD;
use App\MoneyRules\OriginalDnDAlternative;
use App\MoneyRules\SecondEdition;
use App\MoneyRules\ThirdEdition_3;
use App\MoneyRules\ThirdEdition_35;
use App\MoneyRules\ValueType;
use Illuminate\Support\Facades\Vite;
use Livewire\Component;

// https://dungeonsdragons.fandom.com/wiki/Coinage#Publication_history

class DnDCalculator extends Component
{
    public string  $dnd_version                     = "";
    public         $edition_names                   = [];
    public string  $conversion_center               = "gp";
    public string  $money_string                    = "";
    public string  $money_reference                 = "";
    public string  $money_weight_rule               = "";
    public string  $money_conversion_string         = "";
    public array   $money_conversion_table_headings = [];
    public array   $money_conversion_table          = [];
    public string  $money_value                     = "";
    public ?string $money_weight                    = null;
    public string  $money_optimal_value             = "";
    public ?string $money_optimal_weight            = null;
    public string  $money_gold_value                = "";
    public ?string $money_gold_weight               = null;
    public array   $money_short_names               = [];
    public array   $money_long_names                = [];
    public string  $calc_string                     = "";

    private $rules = [];
    /**
     * @var null|IMoneyRules
     */
    private $money_rule = null;

    public function boot(): void
    {
        $this->rules[] = new DnD2024();
        $this->rules[] = new FifthEdition();
        $this->rules[] = new FourthEdition();
        $this->rules[] = new ThirdEdition_35();
        $this->rules[] = new ThirdEdition_3();
        $this->rules[] = new SecondEdition();
        $this->rules[] = new FirstEdition();
        $this->rules[] = new BasicSetRulesCyclopediaIMoneyRules();
        $this->rules[] = new BasicSetBECMI();
        $this->rules[] = new BasicSetMoldvay();
        $this->rules[] = new BasicSetHolmes();
        $this->rules[] = new OriginalDnDAlternative();
        $this->rules[] = new OriginalDnD();

        $this->edition_names = [];
        foreach($this->rules as $rule)
        {
            $this->edition_names[] = $rule->getName();
        }
        $this->setMoneyRule();
    }

    public function getRandomBottomImage(): string
    {
        $possible_images = [
            Vite::asset('resources/images/chests_wide-sm.webp') => 'Chests of treasure',
            Vite::asset('resources/images/scale2-sm.webp')      => 'Scale weighing coins',
            Vite::asset('resources/images/bank_vault-sm.webp')  => 'Bank vault of treasure'
        ];

        $img = array_rand($possible_images, 1);

        return sprintf('<img height="439" width="768" class="rounded-3xl" src="%s" alt="%s"/>',
            $img,
            $possible_images[$img]);
    }

    public function getRandomTopImage(): string
    {
        $possible_images = [
            Vite::asset('resources/images/purse-sm.webp')  => 'Leather purse spilling coins',
            Vite::asset('resources/images/chests-sm.webp') => 'Small chest of coins',
            Vite::asset('resources/images/desk-sm.webp')   => 'Desk with coins being counted'
        ];

        $img = array_rand($possible_images, 1);

        return sprintf('<img height="256" width="256" class="rounded-3xl" src="%s" alt="%s"/>',
            $img,
            $possible_images[$img]);
    }

    public function render()
    {

        return view('livewire.dnd-calculator', ['money_rule' => $this->money_rule])->title('D&D Money Calculator for all editions');
    }

    public function updated($name): void
    {
        if($name == 'dnd_version')
        {
            $this->conversion_center = "gp";
            $this->setMoneyRule();
        }
        if($name == 'conversion_center')
        {
            $this->money_conversion_string = $this->money_rule->getConversionString($this->conversion_center);
        }

        if($name == 'calc_string')
        {

            $parts = preg_split('/\s*([+\-*\\/])\s*/', $this->calc_string, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

            if(count($parts) == 3)
            {
                $amount_pattern = $this->money_rule->getAmountRegexPattern();
                if(preg_match_all($amount_pattern, $parts[0], $lhs, PREG_SET_ORDER) && preg_match_all($amount_pattern, $parts[2], $rhs, PREG_SET_ORDER))
                {

                }

            }
//            $amount_pattern = $this->money_rule->getAmountRegexPattern();
//            preg_match_all($amount_pattern, $this->money_string, $matches, PREG_SET_ORDER);
        }

        $this->recalcMoneyValueWeights();
    }

    private function recalcMoneyValueWeights(): void
    {
        $amount_pattern = $this->money_rule->getAmountRegexPattern();
        preg_match_all($amount_pattern, $this->money_string, $matches, PREG_SET_ORDER);
        foreach($matches as $match)
        {
            $this->money_rule->setCoin($match[1], $match[2]);
        }
        $this->money_value  = $this->money_rule->getValue();
        $this->money_weight = $this->money_rule->getWeight();

        $this->money_optimal_value  = $this->money_rule->getValue(ValueType::OptimalWeight);
        $this->money_optimal_weight = $this->money_rule->getWeight(ValueType::OptimalWeight);

        $this->money_gold_value  = $this->money_rule->getValue(ValueType::OptimalGold);
        $this->money_gold_weight = $this->money_rule->getWeight(ValueType::OptimalGold);

    }

    private function setMoneyRule(): void
    {
        if(is_numeric($this->dnd_version) && $this->dnd_version >= 0 && $this->dnd_version < count($this->rules))
        {
            $this->money_rule                      = $this->rules[$this->dnd_version];
            $this->money_reference                 = $this->money_rule->getReference();
            $this->money_conversion_string         = $this->money_rule->getConversionString($this->conversion_center);
            $this->money_weight_rule               = $this->money_rule->getWeightRule();
            $this->money_conversion_table          = $this->money_rule->getConversionTable();
            $this->money_conversion_table_headings = $this->money_rule->getConversionTableColumnHeadings();
            $this->money_value                     = $this->money_rule->getValue();
            $this->money_weight                    = $this->money_rule->getWeight();
            $this->money_short_names               = $this->money_rule->getShortNames();
            $this->money_long_names                = $this->money_rule->getLongNames();
        }

    }
}
