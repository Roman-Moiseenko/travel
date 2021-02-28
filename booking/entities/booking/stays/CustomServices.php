<?php


namespace booking\entities\booking\stays;


use yii\db\ActiveRecord;

/**
 * Class CustomPayment
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $stay_id
 * @property string $name
 * @property integer $value ... размер платежа
 * @property integer $payment ... %, РУБ в сут, РУБ за все время, РУБ в сут с гостя, РУБ за все время с гостя
 * @property
 */
class CustomServices extends ActiveRecord
{
    const PAYMENT_PERCENT = 1;
    const PAYMENT_FIX_DAY = 2;
    const PAYMENT_FIX_ALL = 3;
    const PAYMENT_FIX_DAY_GUEST = 4;
    const PAYMENT_FIX_ALL_GUEST = 5;
    const MAX_SERVICES = 10;


    public static function create($name, $value, $payment): self
    {
        $service = new static();
        $service->name = $name;
        $service->value = $value;
        $service->payment = $payment;
        return $service;
    }

    public function edit($name, $value, $payment): void
    {
        $this->name = $name;
        $this->value = $value;
        $this->payment = $payment;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_stays_services}}';
    }

    public static function listPayment(): array
    {
        return [
            self::PAYMENT_PERCENT => '%',
            self::PAYMENT_FIX_DAY => 'РУБ за сутки',
            self::PAYMENT_FIX_ALL => 'РУБ за проживание',
            self::PAYMENT_FIX_DAY_GUEST => 'РУБ за сутки с гостя',
            self::PAYMENT_FIX_ALL_GUEST => 'РУБ за проживание с гостя',
        ];
    }
}