<?php


namespace booking\forms\art\event;


use booking\entities\art\event\Category;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;

/**
 * Class CategoryForm
 * @package booking\forms\art\event
 * @property MetaForm $meta
 */
class CategoryForm extends CompositeForm
{
    public $name;
    public $slug;
    public $description;
    public $icon;

    public function __construct(Category $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->icon = $category->icon;
            $this->slug = $category->slug;

            $this->meta = new MetaForm($category->meta);
        } else {
            $this->meta = new MetaForm();
        }

        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['name', 'slug', 'icon'], 'string'],
            [['name'], 'required'],
        ];
    }

    protected function internalForms(): array
    {
        return ['meta'];
    }
}