<?php


namespace frontend\controllers;


use booking\entities\Lang;
use yii\web\Controller;

class AjaxController extends Controller
{

    public function actionLangt()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            return Lang::t($params['text']);
        }
    }

    public function actionLangcurrent()
    {
        if (\Yii::$app->request->isAjax) {
            return Lang::current();
        }
    }

}