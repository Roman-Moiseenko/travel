<?php


namespace booking\forms\office\guides;


use booking\entities\shops\products\Material;
use booking\entities\shops\TypeShop;
use yii\base\Model;

class MaterialForm extends Model
{
    public $name;
    public $slug;

    public function __construct(Material $type = null, $config = [])
    {
        if ($type != null) {
            $this->name = $type->name;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
            ['name', 'required'],
        ];
    }
}