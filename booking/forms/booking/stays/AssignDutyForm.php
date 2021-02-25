<?php


namespace booking\forms\booking\stays;


use booking\entities\booking\stays\duty\AssignDuty;
use booking\entities\booking\stays\duty\Duty;
use yii\base\Model;

class AssignDutyForm extends Model
{

    public $duty_id;
    public $payment;
    public $include;
    public $value;

    public $_duty;
    public function __construct(Duty $duty, AssignDuty $assignDuty = null, $config = [])
    {
        $this->_duty = $duty;
        if ($assignDuty) {
            $this->duty_id = $assignDuty->duty_id;
            $this->payment = $assignDuty->payment;
            $this->value = $assignDuty->value;
            $this->include = $assignDuty->include;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['duty_id', 'payment'], 'integer'],
            ['include', 'boolean'],
            ['value', 'number'],
        ];
    }

    public function getId()
    {
        return $this->_duty->id;
    }

    public function getName()
    {
        return $this->_duty->name;
    }
}