<?php


namespace admin\controllers\stay;

use admin\forms\StaySearch;
use booking\entities\booking\stays\nearby\Nearby;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayComfortForm;
use booking\forms\booking\stays\StayCommonForm;
use booking\forms\booking\stays\StayNearbyForm;
use booking\forms\booking\stays\StayRulesForm;
use booking\helpers\BookingHelper;
use booking\services\booking\stays\StayService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class NearbyController extends Controller
{
    public  $layout = 'main-stays';
    /**
     * @var StayService
     */
    private $service;


    public function __construct($id, $module, StayService $service, $config = [])
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
        $form = new StayNearbyForm($stay);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setNearby($stay->id, $form);
                if ($stay->filling) {
                    return $this->redirect($this->service->next_filling($stay));
                } else {
                    return $this->redirect(['/stay/nearby', 'id' => $stay->id]);
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
                //$stay_id = (int)$params['stay_id'];
                $category_id = (int)$params['category_id'];
                $nearby = [];
                if (isset($params['nearby'])) {
                    $_nearby = $params['nearby'];
                    foreach ($_nearby as $i => $item) {
                        $new_nearby = Nearby::create($item[0], $item[1], $category_id, $item[2]);
                        $nearby[] = $new_nearby;
                    }
                }
                if ($params['status'] == "add")
                    $nearby[] = Nearby::create('', '', $category_id, '');
                return $this->render('_nearby_list', [
                    'nearby' => $nearby,
                    'category_id' => $category_id,
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
                throw new \DomainException('У вас нет прав для данного жилья');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}