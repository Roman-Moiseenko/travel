<?php


namespace frontend\controllers\cars;


use yii\web\Controller;

class CarsController extends Controller
{
    public $layout = 'tours';

    public function actionIndex()
    {
        return $this->redirect(['/tours']);
    }
}