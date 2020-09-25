<?php


namespace booking\entities\booking\cars;


use yii\db\ActiveRecord;

class Car extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%booking_cars}}';
    }
}