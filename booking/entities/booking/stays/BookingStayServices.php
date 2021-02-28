<?php


namespace booking\entities\booking\stays;


use yii\db\ActiveRecord;

/**
 * Class BookingStayPayment
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $booking_id
 //__property integer $services_id
///Дублирование с CustomServices::class в случае замены, т.к. остается в платежах
 * @property string $name
 * @property integer $value ... размер платежа
 * @property integer $payment ... %, РУБ в сут, РУБ за все время, РУБ в сут с гостя, РУБ за все время с гостя
 */

class BookingStayServices extends ActiveRecord
{

    public function create($name, $value, $payment): self
    {
        $service = new static();
        $service->name = $name;
        $service->value = $value;
        $service->payment = $payment;
        return $service;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_stays_calendar_booking_service}}';
    }
}