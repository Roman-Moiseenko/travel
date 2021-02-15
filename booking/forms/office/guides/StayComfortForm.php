<?php


namespace booking\forms\office\guides;


use booking\entities\booking\stays\comfort\Comfort;
use yii\base\Model;

class StayComfortForm extends Model
{
    public $name;
    public $category_id;
    public $paid;
    public $featured;

    public function __construct(Comfort $comfort = null, $config = [])
    {
        if ($comfort) {
            $this->name = $comfort->name;
            $this->category_id = $comfort->category_id;
            $this->paid = $comfort->paid;
            $this->featured = $comfort->featured;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['category_id', 'integer'],
            [['paid', 'featured'], 'boolean'],
            [['name', 'category_id'], 'required'],
        ];
    }
}