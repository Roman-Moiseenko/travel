<?php


namespace frontend\controllers\stays;


use yii\web\Controller;

class StaysController extends Controller
{
    public $layout = 'tours';

    public function actionIndex()
    {
        return $this->redirect(['/tours']);
    }
}