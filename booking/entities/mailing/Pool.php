<?php


namespace booking\entities\mailing;


use yii\db\ActiveRecord;

class Pool extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%mailing_pool}}';
    }
}