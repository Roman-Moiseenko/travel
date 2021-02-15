<?php


namespace booking\entities\booking\stays\comfort;


use yii\db\ActiveRecord;

//Тип категорий удоства - Уборка и приготовление пищи, Общие удобства, Личная гигиена, ТВ и Интернет .......
// группировка по типам
/**
 * Class ComfortCategory
 * @package booking\entities\booking\stays\comfort
 * @property integer $id
 * @property string $name
 * @property string $image  .... svg-картинка, или класс fontawesome
 * @property integer $sort
 */

class ComfortCategory extends ActiveRecord
{

    public static function create($name, $image): self
    {
        $category = new static();
        $category->name = $name;
        $category->image = $image;
        return $category;
    }

    public function edit($name, $image): void
    {
        $this->name = $name;
        $this->image = $image;
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
        return '{{%booking_stays_comfort_category}}';
    }
}