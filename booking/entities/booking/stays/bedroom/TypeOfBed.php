<?php


namespace booking\entities\booking\stays\bedroom;


use yii\db\ActiveRecord;

/**
 * Class Bed
 * @package booking\entities\booking\stays\bedroom
 * @property integer $id
 * @property string $name
 * @property integer $count
 */
class TypeOfBed extends ActiveRecord
{
    public static function create($name, $count): self
    {
        $bed = new static();
        $bed->name = $name;
        $bed->count = $count;
        return $bed;
    }

    public function edit($name, $count): void
    {
        $this->name = $name;
        $this->count = $count;
    }
    public static function tableName()
    {
        return '{{%booking_stays_bed_type}}';
    }
}