<?php


namespace booking\helpers\shops;


use booking\entities\shops\DeliveryCompany;
use yii\helpers\ArrayHelper;

class DeliveryHelper
{
    public static function list(): array
    {
        return ArrayHelper::map(DeliveryCompany::find()->asArray()->all(), 'id', 'name');
    }
}