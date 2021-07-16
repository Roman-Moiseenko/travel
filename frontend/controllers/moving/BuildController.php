<?php


namespace frontend\controllers\moving;


use yii\web\Controller;

class BuildController extends Controller
{

    public $layout = 'main_moving';

    public function actionIndex()
    {
        return $this->render('index', []);
    }
}