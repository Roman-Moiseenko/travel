<?php


namespace booking\forms\booking;


use booking\entities\booking\AgeLimit;
use yii\base\Model;

class AgeLimitForm extends Model
{
    public $on;
    public $ageMin;
    public $ageMax;

    public function __construct(AgeLimit $agelimit = null, $config = [])
    {
        if ($agelimit != null) {
            $this->on = $agelimit->on;
            $this->ageMin = $agelimit->ageMin;
            $this->ageMax = $agelimit->ageMax;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['on', 'boolean'],
            [['ageMin', 'ageMax'], 'integer']
        ];
    }
}