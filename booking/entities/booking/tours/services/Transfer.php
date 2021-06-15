<?php


namespace booking\entities\booking\tours\services;


use booking\entities\booking\City;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Transfer
 * @package booking\entities\booking\tours\services
 * @property integer $id
 * @property integer $user_id
 * @property integer $from_id
 * @property integer $to_id
 * @property integer $cost
 * @property City $from
 * @property City $to
 */
class Transfer extends ActiveRecord
{
    public static function create($from_id, $to_id, $cost): self
    {
        $transfer = new static();
        $transfer->from_id = $from_id;
        $transfer->to_id = $to_id;
        $transfer->cost = $cost;
        return $transfer;
    }

    public function setCost($cost): void  //Изменять можно только цену, чз модальное окно
    {
        $this->cost = $cost;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%users_tour_transfer}}';
    }

    public function getFrom(): ActiveQuery
    {
        return $this->hasOne(City::class, ['id' => 'from_id']);
    }

    public function getTo(): ActiveQuery
    {
        return $this->hasOne(City::class, ['id' => 'to_id']);
    }
}