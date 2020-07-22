<?php


namespace booking\entities\booking\rooms;


use booking\entities\booking\stays\Stays;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class RoomsType
 * @package booking\entities\booking\rooms
 * @property integer $id
 * @property integer $stays_id
 * @property string $name
 * @property Stays $stays
 */
class RoomsType extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%booking_rooms_type}}';
    }

    public function getStays(): ActiveQuery
    {
        return $this->hasOne(Stays::class, ['stays_id' => 'id']);
    }
}