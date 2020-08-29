<?php


namespace booking\entities;


use booking\entities\user\User;

class Currency
{
   /* const RUB = 1;
    const USD = 2;
    const EURO = 3;
    const PZL = 4;

    public static function current()
    {
        if (\Yii::$app->user->isGuest) {
            if ($cookie = \Yii::$app->request->cookies->get('currency')) return $cookie->value;
          //  $data =\Yii::$app->geo->getData();
           // if ($data != null) return $data['country'];
        } else {

            $user = User::findOne(\Yii::$app->user->id);
            if ($user->preferences == null) {
                //$data =\Yii::$app->geo->getData();
               // if ($data != null) return $data['country'];
            } else {
                return $user->preferences->currency;
            }
        }
        return Currency::RUB;
    }*/
}