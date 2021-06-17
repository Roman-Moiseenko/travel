<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\TourParamsForm;
use booking\services\booking\tours\TourService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ParamsController extends Controller
{
    public  $layout = 'main-tours';
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
        if ($tour->filling) return $this->redirect($this->service->redirect_filling($tour));
        return $this->render('view', [
            'tour' => $tour,
        ]);
    }

    public function actionUpdate($id)
    {
        $tour = $this->findModel($id);
        if ($tour->filling) { $this->layout = 'main-create';}
        $form = new TourParamsForm($tour->params);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setParams($tour->id, $form);
                if ($tour->filling) {
                    return $this->redirect($this->service->next_filling($tour));
                } else {
                    return $this->redirect(['/tour/params', 'id' => $tour->id]);
                }
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'tour' => $tour,
            'model' => $form,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Tour::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данной экскурсии');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}