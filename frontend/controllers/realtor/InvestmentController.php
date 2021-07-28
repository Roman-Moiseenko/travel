<?php


namespace frontend\controllers\realtor;



use yii\web\Controller;

class InvestmentController extends Controller
{

    public $layout = 'main_land';

    public function actionIndex()
    {
        return $this->render('index', []);
    }
}