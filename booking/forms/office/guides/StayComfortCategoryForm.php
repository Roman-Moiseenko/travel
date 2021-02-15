<?php


namespace booking\forms\office\guides;


use booking\entities\booking\stays\comfort\ComfortCategory;
use yii\base\Model;

class StayComfortCategoryForm extends Model
{
    public $name;
    public $image;

    public function __construct(ComfortCategory $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->image = $category->image;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'image'], 'string'],
            ['name', 'required'],
        ];
    }
}