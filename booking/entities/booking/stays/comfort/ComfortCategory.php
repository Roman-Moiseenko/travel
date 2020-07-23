<?php


namespace booking\entities\booking\stays\comfort;


use yii\db\ActiveRecord;

/**
 * Class ComfortCategory
 * @package booking\entities\booking\stays\comfort
 * @property integer $id
 * @property string $name
 * @property integer $sort
 */

class ComfortCategory extends ActiveRecord
{

    public static function create($name, $sort): self
    {
        $category = new static();
        $category->name = $name;
        $category->sort = $sort;
        return $category;
    }

    public function edit($name, $sort): void
    {
        $this->name = $name;
        $this->sort = $sort;
    }

    public static function tableName()
    {
        return '{{%booking_stays_comfort_category}}';
    }
}