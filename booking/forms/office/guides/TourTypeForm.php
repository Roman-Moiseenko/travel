<?php


namespace booking\forms\office\guides;


use booking\entities\booking\tours\Type;
use yii\base\Model;

class TourTypeForm extends Model
{
    public $name;
    public $slug;

    public function __construct(Type $type = null, $config = [])
    {
        if ($type != null) {
            $this->name = $type->name;
            $this->slug = $type->slug;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug'], 'string'],
            ['name', 'required'],
        ];
    }
}