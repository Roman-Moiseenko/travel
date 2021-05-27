<?php


namespace frontend\controllers\moving;


use yii\helpers\Url;
use yii\web\Controller;

class CloseLinkController extends Controller
{
    public function actionGet()
    {
        if (\Yii::$app->request->isAjax) {
            if (\Yii::$app->user->isGuest) {
                return '<a href="' . Url::to(['/login']) . '"></a>';
            }
            return 'ссылка';
        } else {
            return $this->goHome();
        }
    }
}