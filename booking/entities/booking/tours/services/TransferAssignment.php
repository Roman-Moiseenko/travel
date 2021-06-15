<?php


namespace booking\entities\booking\tours\services;


use yii\db\ActiveRecord;

/**
 * Class TransferAssignment
 * @package booking\entities\booking\tours\services
 * @property integer $tour_id
 * @property integer $transfer_id
 */
class TransferAssignment extends ActiveRecord
{
    public static function create($id): self
    {
        $assign = new static();
        $assign->transfer_id = $id;
        return $assign;
    }

    public function isFor($id): bool
    {
        return $this->transfer_id == $id;
    }
    public static function tableName()
    {
        return '{{%booking_tours_transfer_assign}}';
    }
}