<?php


namespace admin\controllers\stay;


use booking\entities\booking\stays\Stay;
use booking\services\booking\tours\StackService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DutyController extends Controller
{
    public  $layout = 'main-stays';
    /**
     * @var StackService
     */
    private $service;

    public function __construct($id, $module, StackService $service, $config = [])
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
        $stay = $this->findModel($id);
        if ($stay->filling) return $this->redirect($this->service->redirect_filling($stay));
        return $this->render('view', [
            'stay' => $stay
        ]);
    }

    public function actionUpdate($id)
    {
        $stay = $this->findModel($id);
        if ($stay->filling) { $this->layout = 'main-create';}
        $form = new StayDutyForm($stay);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setDuty($stay->id, $form);
                if ($stay->filling) {
                    return $this->redirect($this->service->next_filling($stay));
                } else {
                    return $this->redirect(['/stay/duty', 'id' => $stay->id]);
                }
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'stay' => $stay
        ]);
    }

    public function actionAdd()
    {
        if (\Yii::$app->request->isAjax) {
            try {
                $this->layout = 'main_ajax';
                $params = \Yii::$app->request->bodyParams;
                /*
                $category_id = (int)$params['category_id'];
                $nearby = [];
                if (isset($params['nearby'])) {
                    $_nearby = $params['nearby'];
                    foreach ($_nearby as $i => $item) {
                        $new_nearby = Duty::create($item[0]);
                        $nearby[] = $new_nearby;
                    }
                }
                if ($params['status'] == "add")
                    $nearby[] = Duty::create();*/
                return $this->render('_duty_list', [
                   // 'nearby' => $nearby,
                    //'category_id' => $category_id,
                ]);
            } catch (\Throwable $e) {
                return $e->getMessage();
            }

        }
    }

    protected function findModel($id)
    {
        if (($model = Stay::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного жилища');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}