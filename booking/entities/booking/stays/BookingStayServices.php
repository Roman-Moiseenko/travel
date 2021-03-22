<?php


namespace booking\entities\booking\stays;


use yii\db\ActiveRecord;

/**
 * Class BookingStayPayment
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $booking_id
///Дублирование с CustomServices::class в случае замены, т.к. остается в платежах
 * @property string $name
 * @property integer $value ... размер платежа
 * @property integer $payment ... %, РУБ в сут, РУБ за все время, РУБ в сут с гостя, РУБ за все время с гостя
 */

class BookingStayServices extends CustomServices
{

    public static function tableName()
    {
        return '{{%booking_stays_calendar_booking_service}}';
    }
}