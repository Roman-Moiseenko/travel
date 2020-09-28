<?php


namespace booking\entities\booking\tours;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class ToursType
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property string $name
 * @property integer $sort
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

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%booking_tours_type}}';
    }

    public function getStays(): ActiveQuery
    {
        return $this->hasMany(Tour::class, ['type_id' => 'id']);
    }
}