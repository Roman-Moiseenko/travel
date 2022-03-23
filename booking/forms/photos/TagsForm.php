<?php


namespace booking\forms\photos;

use booking\entities\photos\Page;
use booking\entities\photos\Tag;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * @property array $newNames
 */

class TagsForm extends Model
{
    public $existing = [];
    public $textNew;

    public function __construct(Page $page = null, $config = [])
    {
        if ($page) {
            $this->existing = ArrayHelper::getColumn($page->tagAssignments, 'tag_id');
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['existing', 'each', 'rule' => ['integer']],
            ['textNew', 'string'],
            ['existing', 'default', 'value' => []],
        ];
    }

    public function tagsList(): array
    {
        return ArrayHelper::map(Tag::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    }

    public function getNewNames(): array
    {
        return array_filter(array_map('trim', preg_split('#\s*,\s*#i', $this->textNew)));
    }
}