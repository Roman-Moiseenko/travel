<?php


namespace admin\controllers\tours;


use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\ToursCommonForms;
use booking\repositories\booking\tours\ToursRepository;
use booking\services\booking\tours\ToursService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommonController extends Controller
{
    public  $layout = 'main-tours';
    /**
     * @var ToursService
     */
    private $service;

    public function __construct($id, $module, ToursService $service, $config = [])
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
                        //'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $tours = $this->findModel($id);
        if ($tours->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного тура');
        }
        return $this->render('view', [
            'tours' => $tours
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main-tours-create';
        $form = new ToursCommonForms();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $tours = $this->service->create($form);
                \Yii::$app->session->setFlash('success', 'Тур успешно создан, теперь вы можете загрузить фотографии и настроить остальные параметры');
                return $this->redirect(['/tours/common', 'id' => $tours->id]);
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
        $tours = $this->findModel($id);
        if ($tours->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного тура');
        }
        $form = new ToursCommonForms($tours);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($tours->id, $form);
                return $this->redirect(['/tours/common', 'id' => $tours->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'tours' => $tours
        ]);

    }

    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}