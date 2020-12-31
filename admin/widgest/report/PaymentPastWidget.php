<?php


namespace admin\widgest\report;


use yii\base\Widget;

class PaymentPastWidget extends Widget
{

    public $object;

    public function run()
    {

        return $this->render('payment_past', [
        ]);
    }

}