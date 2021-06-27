<?php


namespace booking\entities\booking\trips\activity;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\booking\BookingAddress;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveRecord;

/**
 * Class Activity
 * @package booking\entities\booking\trips\activity
 * @property integer $id
 * @property integer $trip_id
 * @property integer $day ... день от начала тура, начиная с 1го дня
 * @property string $time ... пусто, начало, начало-конец
 * @property string $caption
 * @property string $caption_en
 * @property string $description
 * @property string $description_en
 * @property integer $main_photo_id
 * @property Photo[] $photos
 * @property Photo $mainPhoto
 *
 *
 */
class Activity extends ActiveRecord
{

    /** @var $address BookingAddress */
    public $address;

    public static function tableName()
    {
        return '{{%booking_trips_activity}}';
    }

    public function behaviors()
    {
        return [
            BookingAddressBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'photos',
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
}