<?php


namespace booking\forms;


use booking\entities\admin\Help;
use booking\validators\SlugValidator;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class HelpForm extends Model
{
    public $title;
    public $content;
    public $icon;
    public $parentId;

    public $_page;

    public function __construct(Help $page = null, $config = [])
    {
        if ($page) {
            $this->title = $page->title;
            $this->content = $page->content;
            $this->parentId = $page->parent ? $page->parent->id : null;
            $this->_page = $page;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['parentId'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['content', 'icon'], 'string'],
        ];
    }

    public function parentsList(): array
    {
        return ArrayHelper::map(Help::find()->orderBy('lft')->asArray()->all(), 'id', function (array $page) {
            return ($page['depth'] > 1 ? str_repeat('-- ', $page['depth'] - 1) . ' ' : '') . $page['title'];
        });
    }

}