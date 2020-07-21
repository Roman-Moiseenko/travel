<?php


namespace booking\entities\booking\stays;


use booking\entities\booking\rooms\Rooms;
use yii\db\ActiveRecord;

/**
 * Class Stays
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property string $name
 * @property integer $status
 * @property integer $stars
 * @property float $rating
 * @property integer $main_photo_id
 * @property StaysType $type
 * @property StaysAddress $address
 * @property Geo $geo
 * @property Photo[] $photos
 * @property Review[] $reviews
 * @property Rooms[] $rooms
 *
 */
class Stays extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%booking_stays}}';
    }
}