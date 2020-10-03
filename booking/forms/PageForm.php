<?php


namespace booking\forms;


use booking\entities\Page;
use booking\validators\SlugValidator;
use yii\helpers\ArrayHelper;

class PageForm extends CompositeForm
{
    public $title;
    public $content;
    public $slug;
    public $parentId;

    public $_page;

    public function __construct(Page $page = null, $config = [])
    {
        if ($page) {
            $this->title = $page->title;
            $this->content = $page->content;
            $this->slug = $page->slug;
            $this->meta = new MetaForm($page->meta);
            $this->parentId = $page->parent ? $page->parent->id : null;
            $this->_page = $page;
        }
        else {
            $this->meta = new MetaForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['parentId'], 'integer'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['content'], 'string'],
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
        return ['meta'];
    }
}