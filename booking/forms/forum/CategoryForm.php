<?php


namespace booking\forms\forum;


use booking\entities\forum\Category;
use yii\base\Model;

class CategoryForm extends Model
{
    public $section_id;
    public $name;
    public $description;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->section_id = $category->section_id;
            $this->name = $category->name;
            $this->description = $category->description;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'description'], 'string'],
            [['name', 'section_id'], 'required', 'message' => 'Обязательное поле'],
            ['section_id', 'integer'],
        ];
    }
}