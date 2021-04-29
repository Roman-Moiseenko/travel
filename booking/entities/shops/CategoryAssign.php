<?php


namespace booking\entities\shops;


use yii\db\ActiveRecord;

/**
 * Class CategoryAssign
 * @package booking\entities\shops
 * @property integer $shop_id
 * @property integer $category_id
 */

class CategoryAssign extends ActiveRecord
{
    public static function create($category_id): self
    {
        $assign = new static();
        $assign->category_id = $category_id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->category_id == $id;
    }

    public static function tableName()
    {
        return '{{%shops_category_assign}}';
    }
}