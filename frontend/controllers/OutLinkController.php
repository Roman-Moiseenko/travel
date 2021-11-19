<?php


namespace frontend\controllers;


use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OutLinkController extends Controller
{

    public function actionIndex($link)
    {
        if (!empty($link)) {
            return $this->redirect($link);
        } else {
            throw new NotFoundHttpException('');
        }
    }
}