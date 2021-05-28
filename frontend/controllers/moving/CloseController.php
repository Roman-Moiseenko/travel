<?php


namespace frontend\controllers\moving;


use yii\helpers\Url;
use yii\web\Controller;

class CloseController extends Controller
{
    public function actionGetLink()
    {
        if (\Yii::$app->request->isAjax) {
            if (\Yii::$app->user->isGuest) {
                return '<a href="' . Url::to(['/login']) . '"></a>';
            }
            //$link = \Yii::$app->request->bodyParams['link'];
            //получам ссылку с базы
            return 'ссылка';
        } else {
            return $this->goHome();
        }
    }
}