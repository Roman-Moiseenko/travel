<?php

namespace booking\entities\booking\cars;

use booking\entities\Lang;
use yii\db\ActiveRecord;

/**
 * Class Extra
 * @package booking\entities\booking\cars
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $name_en
 * @property integer $cost
 * @property integer $sort
 * @property string $description
 * @property string $description_en
 */
class Extra extends ActiveRecord
{

    public static function create($user_id, $name, $cost, $sort, $description, $name_en, $description_en): self
    {
        $extra = new static();
        $extra->user_id = $user_id;
        $extra->name = $name;
        $extra->cost = $cost;
        $extra->sort = $sort;
        $extra->description = $description;

        $extra->name_en = $name_en;
        $extra->description_en = $description_en;
        return $extra;
    }

    public function edit($name, $cost, $description, $name_en, $description_en): void
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->description = $description;

        $this->name_en = $name_en;
        $this->description_en = $description_en;
    }

    public static function tableName()
    {
        return '{{%booking_cars_extra}}';
    }

    public function getName()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->name_en)) ? $this->name : $this->name_en;
    }

    public function getDescription()
    {
        return (Lang::current() == Lang::DEFAULT || empty($this->description_en)) ? $this->description : $this->description_en;
    }
}