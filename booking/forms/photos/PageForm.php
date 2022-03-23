<?php
declare(strict_types=1);

namespace booking\forms\photos;

use booking\entities\photos\Page;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use yii\base\Model;

/**
 * @property MetaForm $meta
 * @property TagsForm $tags
 */
class PageForm extends CompositeForm
{
    public $title;
    public $description;
//    public $slug

    public function __construct(Page $page = null, $config = [])
    {
        if ($page) {
            $this->title = $page->title;
            $this->description = $page->description;

            $this->meta = new MetaForm($page->meta);
            $this->tags = new TagsForm($page);
        } else {
            $this->meta = new MetaForm();
            $this->tags = new TagsForm();
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title'], 'required', 'message' => 'Обязательное поле'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }


    protected function internalForms(): array
    {
        return ['meta', 'tags'];
    }
}