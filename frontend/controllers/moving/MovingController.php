<?php


namespace frontend\controllers\moving;


use yii\web\Controller;

class MovingController extends Controller
{
    public $layout = 'main_moving_landing';

    public function actionIndex()
    {
        return $this->render('index', []);
    }

}