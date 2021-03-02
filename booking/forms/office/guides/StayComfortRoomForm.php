<?php


namespace booking\forms\office\guides;


use booking\entities\booking\stays\comfort\Comfort;
use booking\entities\booking\stays\comfort_room\ComfortRoom;
use yii\base\Model;

class StayComfortRoomForm extends Model
{
    public $name;
    public $category_id;
    public $photo;
    public $featured;

    public function __construct(ComfortRoom $comfort = null, $config = [])
    {
        if ($comfort) {
            $this->name = $comfort->name;
            $this->category_id = $comfort->category_id;
            $this->photo = $comfort->photo;
            $this->featured = $comfort->featured;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'string'],
            ['category_id', 'integer'],
            [['photo', 'featured'], 'boolean'],
            [['name', 'category_id'], 'required'],
        ];
    }
}