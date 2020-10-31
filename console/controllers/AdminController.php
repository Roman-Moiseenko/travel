<?php


namespace console\controllers;


use booking\entities\admin\User;
use yii\console\Controller;

class AdminController extends Controller
{

    /** Если проплаченное время вышло, то меняем аккаунт на бесплатный */

    public function actionPayment()
    {
        $current_at = time();
        $users = User::find()->andWhere(['<>', 'payment_level', User::PAYMENT_FREE])->all();
        foreach ($users as $user) {
            if ($user->payment_at < $current_at) {
                $user->setPayment(User::PAYMENT_FREE);
                $user->save();
            }
        }
    }
}