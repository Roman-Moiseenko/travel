<?php


namespace booking\forms\forum;


use booking\entities\forum\Category;
use yii\base\Model;

class CategoryForm extends Model
{
    public $name;
    public $description;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->description = $category->description;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            ['name', 'required', 'message' => 'Обязательное поле'],
        ];
    }
}