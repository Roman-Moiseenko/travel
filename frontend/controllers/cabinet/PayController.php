<?php


namespace frontend\controllers\cabinet;


use yii\filters\AccessControl;
use yii\web\Controller;

class PayController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        //'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionTour($id)
    {
        if (\Yii::$app->params['NotPay']) {
            //TODO Подтверждение по СМС
            //генерируем код СМС
            //сохраняем гдето в базе
            //отправляем СМС
            //через форму ждем код
            //если совпал, то подтверждение


            return $this->redirect(['/cabinet/tour/view', 'id' => $id]);
        }
    }

    public function actionStay($id)
    {
        //
    }

    public function actionConfirmation()
    {

    }


}