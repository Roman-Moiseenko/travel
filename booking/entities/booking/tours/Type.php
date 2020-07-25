<?php


namespace booking\entities\booking\tours;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ToursType
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property string $name
 */

class Type extends ActiveRecord
{
    public static function create($name): self
    {
        $type = new static();
        $type->name = $name;
        return $type;
    }

    public function edit($name): void
    {
        $this->name = $name;
    }

    public static function tableName()
    {
        return '{{%booking_tours_type}}';
    }

    public function getStays(): ActiveQuery
    {
        return $this->hasMany(Tours::class, ['type_id' => 'id']);
    }
}