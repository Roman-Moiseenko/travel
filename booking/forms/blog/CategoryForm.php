<?php


namespace booking\forms\blog;


use booking\entities\blog\Category;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use booking\validators\SlugValidator;

/**
 * @property MetaForm $meta;
 */

class CategoryForm extends CompositeForm
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $sort;

    private $_category;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category)
        {
            $this->name = $category->name;
            $this->slug = $category->slug;
            $this->title = $category->title;
            $this->description = $category->description;
            $this->meta = new MetaForm($category->meta);
            $this->_category = $category;

            $this->sort = $category->sort;
        } else {
            $this->meta = new MetaForm();
            $this->sort = Category::find()->max('sort') + 1;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Обязательное поле'],
            [['sort'], 'integer'],
            [['name', 'slug', 'title'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['slug', SlugValidator::class],
            [
                ['name', 'slug'],
                'unique',
                'targetClass' => Category::class,
                'filter' => $this->_category ? ['<>', 'id', $this->_category->id] : null, 'message' => 'Не уникальная комбинация имя+ссылка'
            ],

        ];
    }

    protected function internalForms(): array
    {
        return [
            'meta'
        ];
    }
}