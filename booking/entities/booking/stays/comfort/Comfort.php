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
 * @property boolean $paid ... возможность взимать оплату
 * @property boolean $featured
 * @property boolean $photo ... возможность назначать фото из галереи
 * @property ComfortCategory $category
 */
class Comfort extends ActiveRecord
{
    public static function create($category_id, $name, $paid, $featured, $photo): self
    {
        $comfort = new static();
        $comfort->category_id = $category_id;
        $comfort->name = $name;
        $comfort->paid = $paid;
        $comfort->featured = $featured;
        $comfort->photo = $photo;
        return $comfort;
    }

    public function featured(): void
    {
        $this->featured = true;
    }

    public function edit($category_id, $name, $paid, $featured, $photo): void
    {
        $this->category_id = $category_id;
        $this->name = $name;
        $this->paid = $paid;
        $this->featured = $featured;
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
        return '{{%booking_stays_comfort}}';
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(ComfortCategory::class, ['id' => 'category_id']);
    }
}