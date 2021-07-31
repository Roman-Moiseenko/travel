<?php


namespace booking\forms\night;

use booking\entities\night\Page;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use booking\validators\SlugValidator;
use yii\helpers\ArrayHelper;

/**
 * Class PageForm
 * @package booking\forms
 * @property MetaForm $meta
 * @property PhotosForm $photo
 */

class PageForm extends CompositeForm
{
    public $title;
    public $name;
    public $content;
    public $slug;
    public $parentId;
    public $icon;
    public $description;

    public $_page;

    public function __construct(Page $page = null, $config = [])
    {
        if ($page) {
            $this->title = $page->title;
            $this->name = $page->name;
            $this->content = $page->content;
            $this->description = $page->description;
            $this->slug = $page->slug;
            $this->meta = new MetaForm($page->meta);
            $this->parentId = $page->parent ? $page->parent->id : null;
            $this->icon = $page->icon;
            $this->_page = $page;
        }
        else {
            $this->meta = new MetaForm();
        }
        $this->photo = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title', 'name', 'description'], 'required'],
            [['parentId'], 'integer'],
            [['title', 'slug', 'icon', 'name'], 'string', 'max' => 255],
            [['content', 'description'], 'string'],
            ['slug', SlugValidator::class],
            [['slug'], 'unique', 'targetClass' => Page::class, 'filter' => $this->_page ? ['<>', 'id', $this->_page->id] : null]
        ];
    }

    public function parentsList(): array
    {
        return ArrayHelper::map(Page::find()->orderBy('lft')->asArray()->all(), 'id', function (array $page) {
            return ($page['depth'] > 1 ? str_repeat('-- ', $page['depth'] - 1) . ' ' : '') . $page['title'];
        });
    }

    public function internalForms(): array
    {
        return ['meta', 'photo'];
    }
}