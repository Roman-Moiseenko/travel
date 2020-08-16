<?php


namespace admin\controllers\tours;


use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\ToursParamsForm;
use booking\services\booking\tours\ToursService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ParamsController extends Controller
{
    public  $layout = 'main-tours';
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
            'tours' => $tours,
        ]);
    }

    public function actionUpdate($id)
    {
        $tours = $this->findModel($id);
        if ($tours->user_id != \Yii::$app->user->id) {
            throw new \DomainException('У вас нет прав для данного тура');
        }

        $form = new ToursParamsForm($tours->params);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setParams($tours->id, $form);
                return $this->redirect(['/tours/params', 'id' => $tours->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'tours' => $tours,
            'model' => $form,
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