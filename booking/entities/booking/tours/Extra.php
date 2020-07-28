<?php


namespace booking\entities\booking\tours;


use booking\entities\booking\stays\rules\Cards;
use yii\db\ActiveRecord;

/**
 * Class Extra
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $cost
 * @property integer $sort
 * @property string $description
 */
class Extra extends ActiveRecord
{

    public static function create($user_id, $name, $cost, $sort, $description): self
    {
        $extra = new static();
        $extra->user_id = $user_id;
        $extra->name = $name;
        $extra->cost = $cost;
        $extra->sort = $sort;
        $extra->description = $description;
        return $extra;
    }

    public function edit($name, $cost, $description): void
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->description = $description;
    }

    public static function tableName()
    {
        return '{{%booking_tours_extra}}';
    }
}