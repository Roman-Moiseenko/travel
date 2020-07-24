<?php


namespace frontend\controllers\tours;


use yii\web\Controller;

class ToursController extends Controller
{
    public $layout = 'tours';

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        return $this->render('index', []);
    }

    public function actionType($id)
    {
        return $this->render('category', [
            'id' => $id
        ]);
    }

    public function actionTour($id)
    {
        $this->layout = 'tours_blank';
        return $this->render('tour', [
            'id' => $id
        ]);
    }

}