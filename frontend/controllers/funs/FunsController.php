<?php


namespace frontend\controllers\funs;


use yii\web\Controller;

class FunsController extends Controller
{
    public $layout = 'tours';

    public function actionIndex()
    {
        return $this->redirect(['/tours']);
    }
}