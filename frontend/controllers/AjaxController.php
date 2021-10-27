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

    public function actionLoad()
    {
        $this->enableCsrfValidation = false;
        $params = \Yii::$app->request->post();
        \Yii::error($params);
        $filename = "data.txt"; //
        return \Yii::$app->request->getCsrfToken();
        //return file_put_contents($filename, $params, FILE_APPEND | LOCK_EX);

    }
}