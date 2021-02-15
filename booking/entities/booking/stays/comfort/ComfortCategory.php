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

    public static function create($name, $image, $sort): self
    {
        $category = new static();
        $category->name = $name;
        $category->image = $image;
        $category->sort = $sort;
        return $category;
    }

    public function edit($name, $image, $sort): void
    {
        $this->name = $name;
        $this->image = $image;
        $this->sort = $sort;
    }

    public static function tableName()
    {
        return '{{%booking_stays_comfort_category}}';
    }
}