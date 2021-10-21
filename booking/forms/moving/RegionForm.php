<?php


namespace booking\forms\moving;


use booking\entities\moving\agent\Region;
use yii\base\Model;

class RegionForm extends Model
{
    public $name;
    public $link;

    public function __construct(Region $region = null, $config = [])
    {
        if ($region) {
            $this->name = $region->name;
            $this->link = $region->link;
        }

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'link'], 'string'],
            [['name'], 'required'],
        ];
    }
}