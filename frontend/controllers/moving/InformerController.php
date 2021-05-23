<?php


namespace frontend\controllers\moving;


use yii\web\Controller;

class InformerController extends Controller
{

    public $layout = 'main_moving';

    public function actionIndex()
    {
        //TODO делаем аналог Page
        return $this->render('index', []);
    }
}