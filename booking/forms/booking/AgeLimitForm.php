<?php


namespace booking\forms\booking;


use booking\entities\booking\AgeLimit;
use yii\base\Model;

class AgeLimitForm extends Model
{
    public $on;
    public $ageMin;
    public $ageMax;

    public function __construct(AgeLimit $ageLimit = null, $config = [])
    {
        if ($ageLimit != null) {
            $this->on = $ageLimit->on;
            $this->ageMin = $ageLimit->ageMin;
            $this->ageMax = $ageLimit->ageMax;
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