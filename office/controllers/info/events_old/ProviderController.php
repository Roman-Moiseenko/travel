<?php


namespace office\controllers\info\events;


use booking\entities\events\Provider;
use booking\entities\Rbac;
use booking\forms\events\ProviderForm;
use booking\services\events\ProviderService;
use office\forms\info\events\ProviderSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProviderController extends Controller
{

    /**
     * @var ProviderService
     */
    private $service;

    public function __construct($id, $module, ProviderService $service, $config = [])
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
        $searchModel = new ProviderSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        try {
            $provider = Provider::findOne($id);
            return $this->render('view', [
                'provider' => $provider,
            ]);
        } catch (NotFoundHttpException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->redirect(Url::to('index'));
        }
    }

    public function actionCreate()
    {
        $form = new ProviderForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $provider = $this->service->create($form);
                return $this->redirect(['info/events/provider/view', 'id' => $provider->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }


}