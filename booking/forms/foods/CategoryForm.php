<?php


namespace booking\forms\foods;


use booking\entities\foods\Category;
use booking\entities\foods\Kitchen;
use yii\base\Model;

class CategoryForm extends Model
{
    public $name;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['name', 'required'],
        ];
    }
}