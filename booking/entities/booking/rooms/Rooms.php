<?php


namespace booking\entities\booking\rooms;


use yii\db\ActiveRecord;

/**
 * Class Rooms
 * @package booking\entities\booking\rooms
 * @property integer $id
 * @property integer $stays_id
 * @property string $name
 * @property integer $baseprice
 * @property integer $count
 * @property integer $capacity
 * @property float $square
 * @property integer $subrooms
 * @property Photo[] $photos
 */

class Rooms extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%booking_rooms}}';
    }
}