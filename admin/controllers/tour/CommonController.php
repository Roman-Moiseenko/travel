<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\ToursCommonForms;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CommonController extends Controller
{
    public  $layout = 'main-tours';
    /**
     * @var TourService
     */
    private $service;

    public function __construct($id, $module, TourService $service, $config = [])
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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $tour = $this->findModel($id);
        return $this->render('view', [
            'tour' => $tour
        ]);
    }

    public function actionCreate()
    {
        $this->layout = 'main-tours-create';
        $form = new ToursCommonForms();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $tour = $this->service->create($form);
                \Yii::$app->session->setFlash('success', 'Тур успешно создан, теперь вы можете загрузить фотографии и настроить остальные параметры');
                return $this->redirect(['/tour/common', 'id' => $tour->id]);
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
        $tour = $this->findModel($id);
        $form = new ToursCommonForms($tour);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($tour->id, $form);
                return $this->redirect(['/tour/common', 'id' => $tour->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'tour' => $tour
        ]);

    }

    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}