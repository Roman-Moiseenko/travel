<?php


namespace booking\forms\moving;


use booking\entities\moving\CategoryFAQ;
use yii\base\Model;

class CategoryFAQForm extends Model
{
    public $caption;
    public $description;

    public function __construct(CategoryFAQ $category = null, $config = [])
    {
        if ($category != null) {
            $this->caption = $category->caption;
            $this->description = $category->description;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['caption', 'description'], 'string'],
            ['caption', 'required'],
        ];
    }
}