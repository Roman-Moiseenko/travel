<?php


namespace booking\forms\office\guides;


use booking\entities\booking\tours\Type;
use booking\entities\forum\Section;
use yii\base\Model;

class SectionForm extends Model
{
    public $caption;
    public $slug;

    public function __construct(Section $section = null, $config = [])
    {
        if ($section != null) {
            $this->caption = $section->caption;
            $this->slug = $section->slug;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['caption', 'slug'], 'string'],
            ['caption', 'required'],
        ];
    }
}