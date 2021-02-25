<?php


namespace booking\forms\office\guides;


use booking\entities\booking\City;
use booking\entities\booking\stays\duty\Duty;
use booking\entities\message\ThemeDialog;
use yii\base\Model;

class DutyForm extends Model
{
    public $name;

    public function __construct(Duty $duty = null, $config = [])
    {
        if ($duty != null) {
            $this->name = $duty->name;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['name'], 'required'],
        ];
    }
}