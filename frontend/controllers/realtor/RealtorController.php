<?php


namespace frontend\controllers\realtor;


use booking\entities\realtor\land\Land;
use booking\entities\land\Point;
use booking\repositories\realtor\land\LandRepository;
use yii\web\Controller;

class RealtorController extends Controller
{

    public $layout = 'main_land';


    public function actionIndex()
    {
        return $this->render('index', []);
    }

}