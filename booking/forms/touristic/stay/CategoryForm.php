<?php


namespace booking\forms\touristic\stay;


use booking\entities\touristic\stay\Category;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;

/**
 * Class CategoryForm
 * @package booking\forms\touristic\fun
 * @property PhotosForm $photo
 * @property MetaForm $meta
 */
class CategoryForm extends CompositeForm
{
    public $name;
    public $slug;
    public $description;
    public $title;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->title = $category->title;
            $this->slug = $category->slug;
            $this->description = $category->description;
            $this->meta = new MetaForm($category->meta);
        } else {
            $this->meta = new MetaForm();
        }

        $this->photo = new PhotosForm();

        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['name', 'slug', 'description', 'title'], 'string'],
            [['name', 'title'], 'required'],
        ];
    }

    protected function internalForms(): array
    {
        return ['photo', 'meta'];
    }
}