<?php


namespace frontend\controllers;


use yii\web\Controller;

class MovingController extends Controller
{
    public $layout = 'main_moving';

    public function actionIndex()
    {
        return $this->render('index', []);
    }


    public function actionForum()
    {
        return $this->render('forum', []);
    }
}