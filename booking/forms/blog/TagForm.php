<?php


namespace booking\forms\blog;


use booking\entities\blog\Tag;
use booking\validators\SlugValidator;
use yii\base\Model;

class TagForm extends Model
{
    public $name;
    public $slug;
    private $_tag;

    public function __construct(Tag $tag = null, $config = [])
    {
        if ($tag) {
            $this->name = $tag->name;
            $this->slug = $tag->slug;
            $this->_tag = $tag;
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Обязательное поле'],
            [['name', 'slug'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
            [
                ['name', 'slug'],
                'unique',
                'targetClass' => Tag::class,
                'filter' => $this->_tag ? ['<>', 'id', $this->_tag->id] : null, 'message' => 'Не уникальная комбинация имя+ссылка'],
        ];

    }
}