<?php


namespace booking\entities\booking\stays;

use booking\helpers\SlugHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Type
 * @package booking\entities\booking
 * @property integer $id
 * @property string $name
 * @property integer $sort
 * @property string $slug
 */

//Квартира, Аппартаменты, Пентхаус, Загородный дом, Дача, Коттедж, Таунхаус
class Type extends ActiveRecord
{
    public static function create($name, $slug): self
    {
        $type = new static();
        $type->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $type->slug = $slug;
        return $type;
    }

    public function edit($name, $slug): void
    {
        $this->name = $name;
        if (empty($slug)) $slug = SlugHelper::slug($name);
        $this->slug = $slug;
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
        return 'booking_stays_type';
    }
}