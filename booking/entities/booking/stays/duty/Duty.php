<?php


namespace booking\entities\booking\stays\duty;


use yii\db\ActiveRecord;

/**
 * Class DutyType
 * @package booking\entities\booking\stays\duty
 * @property integer $id
 * @property string $name
 * @property integer $sort
 */
class Duty extends ActiveRecord
{
    const PAYMENT_PERCENT = 1;
    const PAYMENT_FIX_DAY = 2;
    const PAYMENT_FIX_ALL = 3;

    public static function create($name): self
    {
        $type = new static();
        $type->name = $name;
        return $type;
    }

    public function edit($name)
    {
        $this->name = $name;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_stays_duty}}';
    }

    public static function listPayment(): array
    {
        return [
            self::PAYMENT_PERCENT => '%',
            self::PAYMENT_FIX_DAY => 'РУБ за сутки',
            self::PAYMENT_FIX_ALL => 'РУБ за проживание',
        ];
    }
}