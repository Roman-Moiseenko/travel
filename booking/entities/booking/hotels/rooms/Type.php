<?php


namespace booking\entities\booking\hotels\rooms;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Type
 * @package booking\entities\booking\rooms
 * @property integer $id
 * @property integer $stays_id
 * @property string $name
 * @property Type $staystype
 */
class Type extends ActiveRecord
{
    public static function create($stays_id, $name): self
    {
        $type = new static();
        $type->stays_id = $stays_id;
        $type->name = $name;
        return $type;
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
        return $this->hasOne(\booking\entities\booking\stays\Type::class, ['stays_id' => 'id']);
    }
}