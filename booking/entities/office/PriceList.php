<?php


namespace booking\entities\office;


use yii\db\ActiveRecord;

/**
 * Class PriceList
 * @package booking\entities\office
 * @property integer $id
 * @property string $key
 * @property float $amount
 * @property integer $period
 */
class PriceList extends ActiveRecord
{
    const PERIOD_MONTH = 1;
    const PERIOD_ALL = 99;



    public static function tableName()
    {
        return '{{%office_price_list}}';
    }

}