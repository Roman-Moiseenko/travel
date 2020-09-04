<?php


namespace admin\controllers\tour;


use admin\forms\tours\ExtraSearch;
use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\ExtraForm;
use booking\forms\booking\tours\ToursExtraForm;
use booking\forms\booking\tours\ToursParamsForm;
use booking\repositories\booking\tours\ExtraRepository;
use booking\services\booking\tours\ExtraService;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ExtraController extends Controller
{
    public  $layout = 'main-tours';
    private $service;
    /**
     * @var ExtraRepository
     */
    private $extra;
    /**
     * @var ExtraService
     */
    private $extraService;

    public function __construct($id, $module, TourService $service, ExtraRepository $extra, ExtraService $extraService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->extra = $extra;
        $this->extraService = $extraService;
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
        $searchModel = new ExtraSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tour' => $tour,
        ]);
    }


    public function actionSetextra($tours_id, $extra_id, $set = false)
    {
        $this->service->setExtra($tours_id, $extra_id, $set);
    }



    public function actionCreate($id)
    {
        $tour = $this->findModel($id);
        $form = new ExtraForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->extraService->create($tour->user_id, $form);
                return $this->redirect(['/tour/extra', 'id' => $tour->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'tour' => $tour,
            'model' => $form,
        ]);
    }
    public function actionUpdate($id, $extra_id)
    {
        $tour = $this->findModel($id);
        $extra = $this->extra->get($extra_id);
        $form = new ExtraForm($extra);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->extraService->edit($extra->id, $form);
                return $this->redirect(['/tour/extra', 'id' => $tour->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'tour' => $tour,
            'extra' => $extra,
            'model' => $form,
        ]);
    }

    public function actionDelete($id, $extra_id)
    {
        $tour = $this->findModel($id);
        $this->extraService->remove($extra_id);
        return $this->redirect(['/tour/extra', 'id' => $tour->id]);
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