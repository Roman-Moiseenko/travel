<?php


namespace booking\entities\art\event;


use booking\entities\booking\BookingAddress;
use yii\db\ActiveRecord;

/**
 * Class Calendar
 * @package booking\entities\art\event
 * @property integer $id
 * @property integer $event_id
 * @property integer $date_begin
 * @property integer $date_end
 * @property string $time_begin
 * @property string $description
 *
 * @property
 */
class Calendar extends ActiveRecord
{
    /** @var $address BookingAddress */
    public $address;

    public static function tableName()
    {
        return '{{%art_event_calendar}}';
    }
}