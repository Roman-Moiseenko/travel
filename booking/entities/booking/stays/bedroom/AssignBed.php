<?php


namespace booking\entities\booking\stays\bedroom;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class AssignBed
 * @package booking\entities\booking\stays\bedroom
 * @property integer $assignRoom_id
 * @property integer $bed_id
 * @property integer $count
 * @property TypeOfBed $typeOfBed
 */
class AssignBed extends ActiveRecord
{
    public static function create($bed_id, $count): self
    {
        $assign = new static();
        $assign->bed_id = $bed_id;
        $assign->count = $count;
        return $assign;
    }

    public function edit($bed_id, $count): void
    {
        $this->bed_id = $bed_id;
        $this->count = $count;
    }

    public function isFor($bed_id): bool
    {
        return $this->bed_id == $bed_id;
    }

    public static function tableName()
    {
        return '{{%booking_stays_beds_assign}}';
    }

    public function getTypeOfBed(): ActiveQuery
    {
        return $this->hasOne(TypeOfBed::class, ['id' => 'bed_id']);
    }
}