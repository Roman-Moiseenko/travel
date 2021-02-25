<?php


namespace booking\forms\booking\stays\rules;


use booking\entities\booking\stays\rules\Beds;
use yii\base\Model;

class BedsForm extends Model
{
    public $child_on; //доп.кровать детская
    public $child_agelimit; //до какого возраста кровать
    public $child_cost; //0 - бесплатно, > 0 - платно (цена)
    public $child_by_adult; //С какого возраста считается взрослым, или до какого возраста бесплатно
    public $child_count; //макс.кол-во

    public $adult_on; //доп.кровать
    public $adult_cost; //цена
    public $adult_count; //макс.кол-во

    public function __construct(Beds $bed, $config = [])
    {
        $this->child_on = $bed->child_on;
        $this->child_agelimit = $bed->child_agelimit;
        $this->child_cost = $bed->child_cost;
        $this->child_by_adult = $bed->child_by_adult;
        $this->child_count = $bed->child_count;
        $this->adult_on = $bed->adult_on;
        $this->adult_cost = $bed->adult_cost;
        $this->adult_count = $bed->adult_count;

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['child_on', 'adult_on'], 'boolean'],
            [['child_agelimit', 'child_cost', 'child_by_adult', 'child_count', 'adult_cost', 'adult_count'], 'integer'],
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        if (!$this->child_on) {
            $this->child_agelimit = null;
            $this->child_cost = null;
            $this->child_count = null;
        }
        if (!$this->adult_on) {
            $this->adult_cost = null;
            $this->adult_count = null;
        }
    }
}