<?php


namespace booking\entities\booking\stays\comfort_room;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Comfort
 * @package booking\entities\booking\stays\comfort_room
 * @property integer $id
 * @property integer $category_id
 * @property string $name
 * @property integer $sort
 * @property boolean $photo ... возможность назначать фото из галереи
 * @property ComfortRoomCategory $category
 */
class ComfortRoom extends ActiveRecord
{
    public static function create($category_id, $name, $photo): self
    {
        $comfort = new static();
        $comfort->category_id = $category_id;
        $comfort->name = $name;
        $comfort->photo = $photo;
        return $comfort;
    }

    public function edit($category_id, $name, $photo): void
    {
        $this->category_id = $category_id;
        $this->name = $name;
        $this->photo = $photo;
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
        return '{{%booking_stays_comfort_room}}';
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(ComfortRoomCategory::class, ['id' => 'category_id']);
    }
}