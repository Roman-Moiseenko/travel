<?php


namespace booking\entities\booking\stays\comfort;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Comfort
 * @package booking\entities\booking\stays\comfort
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $sort
 * @property boolean $editpay
 * @property ComfortCategory $category
 */
class Comfort extends ActiveRecord
{
    public static function create($category_id, $name, $editpay, $sort): self
    {
        $comfort = new static();
        $comfort->category_id = $category_id;
        $comfort->name = $name;
        $comfort->editpay = $editpay;
        $comfort->sort = $sort;
        return $comfort;
    }

    public function edit($name, $editpay, $sort): void
    {
        $this->name = $name;
        $this->editpay = $editpay;
        $this->sort = $sort;
    }

    public static function tableName()
    {
        return '{{%booking_stays_comfort}}';
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(ComfortCategory::class, ['id' => 'category_id']);
    }
}