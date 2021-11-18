<?php


namespace booking\entities\art\event;


use yii\db\ActiveRecord;

/**
 * Class CategoryAssignment
 * @package booking\entities\art\event
 * @property integer $event_id
 * @property integer $category_id

 */
class CategoryAssignment extends ActiveRecord
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
        return '{{%art_event_category_assignment}}';
    }
}