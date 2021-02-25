<?php


namespace admin\controllers\stay;

use admin\forms\StaySearch;
use booking\entities\booking\stays\bedroom\AssignBed;
use booking\entities\booking\stays\bedroom\AssignRoom;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayBedroomsForm;
use booking\forms\booking\stays\StayComfortForm;
use booking\forms\booking\stays\StayCommonForm;
use booking\forms\booking\stays\StayRulesForm;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\services\booking\stays\StayService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BedroomsController extends Controller
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
        $form = new StayBedroomsForm($stay);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setBedrooms($stay->id, $form);
                if ($stay->filling) {
                    return $this->redirect($this->service->next_filling($stay));
                } else {
                    return $this->redirect(['/stay/bedrooms', 'id' => $stay->id]);
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
                $stay_id = (int)$params['stay_id'];
                $count_room = (int)$params['count_room'];
                $bedrooms = [];
                if ($count_room != 0) {
                    $_rooms = $params['rooms'];
                    foreach ($_rooms as $i => $room) {
                        $bedroom = AssignRoom::create($stay_id, $i, false);
                        foreach ($room as $j => $item) {
                            if ($item != "") $bedroom->addBed(AssignBed::create($j, (int)$room[$j]));
                        }
                        $bedrooms[] = $bedroom;
                    }
                }
                if ($params['status'] == "add")
                    $bedrooms[] = AssignRoom::create($stay_id, count($bedrooms), false);
                return $this->render('_bedroom', [
                    'bedrooms' => $bedrooms,
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