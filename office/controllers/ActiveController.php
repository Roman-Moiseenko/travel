<?php


namespace office\controllers;


use booking\entities\Rbac;
use office\forms\CarsSearch;
use office\forms\FunsSearch;
use office\forms\ShopsSearch;
use office\forms\StaysSearch;
use office\forms\ToursSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ActiveController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_MANAGER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModelTours = new ToursSearch([
            'verify' => true,
        ]);
        $dataProviderTours = $searchModelTours->search(\Yii::$app->request->queryParams);

        //TODO HotelSearch

        $searchModelStays = new StaysSearch([
            'verify' => true,
        ]);
        $dataProviderStays = $searchModelStays->search(\Yii::$app->request->queryParams);

        $searchModelCars = new CarsSearch([
            'verify' => true,
        ]);
        $dataProviderCars = $searchModelCars->search(\Yii::$app->request->queryParams);

        $searchModelFuns = new FunsSearch([
            'verify' => true,
        ]);
        $dataProviderFuns = $searchModelFuns->search(\Yii::$app->request->queryParams);

        $searchModelShops = new ShopsSearch([
            'verify' => true,
        ]);
        $dataProviderShops = $searchModelShops->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModelTours' => $searchModelTours,
            'dataProviderTours' => $dataProviderTours,

            'searchModelStays' => $searchModelStays,
            'dataProviderStays' => $dataProviderStays,

            'searchModelCars' => $searchModelCars,
            'dataProviderCars' => $dataProviderCars,

            'searchModelFuns' => $searchModelFuns,
            'dataProviderFuns' => $dataProviderFuns,

            'searchModelShops' => $searchModelShops,
            'dataProviderShops' => $dataProviderShops,
        ]);


    }

}