<?php


namespace office\controllers\guides;


use booking\entities\booking\tours\Type;
use booking\entities\message\ThemeDialog;
use booking\entities\Rbac;
use booking\forms\office\guides\ThemeDialogForm;
use booking\forms\office\guides\TourTypeForm;
use booking\services\office\guides\ThemeDialogService;
use booking\services\office\guides\TypeTourService;
use booking\services\DialogService;
use office\forms\guides\ThemeDialogSearch;
use yii\base\Theme;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ThemeDialogController extends Controller
{

    /**
     * @var DialogService
     */
    private $service;

    public function __construct($id, $module, ThemeDialogService $service, $config = [])
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
        $searchModel = new ThemeDialogSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new ThemeDialogForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['guides/theme-dialog/index']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $type = $this->find($id);
        $form = new ThemeDialogForm($type);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($id, $form);
                return $this->redirect(['guides/theme-dialog/index']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function find($id)
    {
        if (!$result = ThemeDialog::findOne($id))
            throw new \DomainException('Не найден элемент');
        return $result;
    }
}