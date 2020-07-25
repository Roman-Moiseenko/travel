<?php


namespace booking\forms\booking\tours;


use booking\entities\booking\tours\Cost;
use yii\base\Model;

class CostForm extends Model
{
    public $adult;
    public $child;
    public $preference;

    public function __construct(Cost $cost = null, $config = [])
    {
        if ($cost) {
            $this->adult = $cost->adult;
            $this->child = $cost->child;
            $this->preference = $cost->preference;
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            ['adult', 'required'],
            [['adult', 'child', 'preference'], 'integer'],
        ];
    }

}