<?php


namespace admin\controllers;


use admin\forms\shops\ShopSearch;
use booking\repositories\shops\ShopRepository;
use yii\filters\AccessControl;
use yii\web\Controller;

class ShopsController extends Controller
{
    public $layout ='main';
    /**
     * @var ShopRepository
     */
    private $shops;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function __construct($id, $module, ShopRepository $shops, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->shops = $shops;
    }

    public function actionIndex()
    {
        $searchModel = new ShopSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}