<?php


namespace office\controllers\finance;


use booking\entities\office\PriceList;
use booking\entities\Rbac;
use booking\forms\office\PriceListForm;
use booking\services\office\PriceListService;
use office\forms\finance\PriceListSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;

class PriceController extends Controller
{

    /**
     * @var PriceListService
     */
    private $service;

    public function __construct($id, $module, PriceListService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_ADMIN],
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
        $searchModel = new PriceListSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionUpdate($id)
    {
        $price = PriceList::findOne($id);
        $form = new PriceListForm($price);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($price->id, $form);
                return $this->redirect(Url::to(['/finance/price']));
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'price' => $price,
            'model' => $form,
        ]);
    }
}