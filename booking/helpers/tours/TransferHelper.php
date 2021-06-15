<?php


namespace booking\helpers\tours;


use booking\entities\booking\tours\services\Capacity;
use booking\entities\booking\tours\services\Transfer;
use booking\helpers\CurrencyHelper;
use yii\helpers\ArrayHelper;

class TransferHelper
{
    public static function list($user_id): array
    {
        return ArrayHelper::map(
            Transfer::find()->andWhere(['user_id' => $user_id])->all(),
            function (Transfer $transfer) { return $transfer->id;},
            function (Transfer $transfer) {
                return $transfer->from->name . ' - ' . $transfer->to->name . ' ' . CurrencyHelper::cost($transfer->cost);
            }
        );
    }
}