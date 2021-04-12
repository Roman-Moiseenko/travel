<?php


namespace booking\forms\blog\map;


use booking\entities\blog\map\Maps;
use yii\base\Model;

class MapsForm extends Model
{
    public $name;
    public $slug;

    public function __construct(Maps $map = null, $config = [])
    {
        if ($map) {
            $this->name = $map->name;
            $this->slug = $map->slug;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug'], 'string'],
            [['name', 'slug'], 'required'],
        ];
    }
}