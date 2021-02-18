<?php


namespace booking\forms\office\guides;


use booking\entities\booking\stays\nearby\NearbyCategory;
use yii\base\Model;

class NearbyCategoryForm extends Model
{
    public $name;
    public $group;

    public function __construct(NearbyCategory $category = null, $config = [])
    {
        if ($category) {
            $this->name = $category->name;
            $this->group = $category->group;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'group'], 'string'],
            [['name', 'group'], 'required'],
        ];
    }
}