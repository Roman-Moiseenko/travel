<?php


namespace booking\entities\booking\rooms;


use booking\entities\booking\stays\StaysType;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class RoomsType
 * @package booking\entities\booking\rooms
 * @property integer $id
 * @property integer $stays_id
 * @property string $name
 * @property StaysType $staystype
 */
class RoomsType extends ActiveRecord
{
    public static function create($stays_id, $name): self
    {
        $rooms = new static();
        $rooms->stays_id = $stays_id;
        $rooms->name = $name;
        return $rooms;
    }

    public function edit($stays_id, $name): void
    {
        $this->stays_id = $stays_id;
        $this->name = $name;
    }

    public static function tableName()
    {
        return '{{%booking_rooms_type}}';
    }

    public function getStaystype(): ActiveQuery
    {
        return $this->hasOne(StaysType::class, ['stays_id' => 'id']);
    }
}