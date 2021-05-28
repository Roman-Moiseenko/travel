<?php


namespace frontend\controllers\moving;


use booking\entities\moving\CloseLink;
use yii\helpers\Url;
use yii\web\Controller;

class CloseController extends Controller
{
    public function actionGetLink()
    {
        if (\Yii::$app->request->isAjax) {
            if (\Yii::$app->user->isGuest) {
                return '<a href="' . Url::to(['/login']) . '">Войти на сайт</a>';
            }
            $link = \Yii::$app->request->bodyParams['link'];
            //получам ссылку с базы
            $url = CloseLink::findOne(['link' => $link]);
            if ($url) {
                return '<a href="' . $url->url . '">' . $url->anchor . '</a>';
            }
            return '';
        } else {
            return $this->goHome();
        }
    }
}