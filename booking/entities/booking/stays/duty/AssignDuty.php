<?php


namespace booking\entities\booking\stays\duty;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class AssignDuty
 * @package booking\entities\booking\stays\duty
 * @property integer $stay_id
 * @property integer $duty_id
 * @property integer $payment
 * @property integer $value - сумма сбора (в руб или в %)
 * @property boolean $include
 * @property Duty $duty
 */

class AssignDuty extends ActiveRecord
{

    public static function create($duty_id, $value, $payment, $include): self
    {
        $duty = new static();
        $duty->duty_id = $duty_id;
        $duty->value = $value;
        $duty->include = $include;
        $duty->payment = $payment;
        return $duty;
    }

    public function edit($duty_id, $value, $payment, $include)
    {
        $this->duty_id = $duty_id;
        $this->value = $value;
        $this->include = $include;
    }

    public function isFor($duty_id): bool
    {
        return $this->duty_id == $duty_id;
    }

    public static function tableName()
    {
        return '{{%booking_stays_duty_assign}}';
    }

    public function getDuty(): ActiveQuery
    {
        return  $this->hasOne(Duty::class, ['id' => 'duty_id']);
    }
}