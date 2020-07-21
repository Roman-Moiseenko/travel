<?php


namespace booking\entities\booking\stays;


use yii\db\ActiveRecord;

/**
 * Class StaysType
 * @package booking\entities\booking
 * @property integer $id
 * @property string $name
 * @property boolean $mono
 */
class StaysType extends ActiveRecord
{
    public function isMono(): boolean
    {
        return $this->mono;
    }

    public static function tableName()
    {
        return 'booking_stays_type';
    }
}