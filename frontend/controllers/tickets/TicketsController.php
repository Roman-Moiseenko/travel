<?php


namespace frontend\controllers\tickets;


use yii\web\Controller;

class TicketsController extends Controller
{
    public $layout = 'tours';

    public function actionIndex()
    {
        return $this->redirect(['/tours']);
    }
}