<?php


namespace admin\controllers\stay;


use booking\entities\booking\stays\CustomServices;
use booking\entities\booking\stays\duty\Duty;
use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayDutyForm;
use booking\forms\booking\stays\StayServicesForm;
use booking\helpers\scr;
use booking\services\booking\stays\StayService;
use booking\services\booking\tours\StackService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ServicesController extends Controller
{
    public $layout = 'main-stays';
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
        if ($stay->filling) {
            $this->layout = 'main-create';
        }
        $form = new StayServicesForm($stay);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                //scr::p($form);
                $this->service->setServices($stay->id, $form);
                if ($stay->filling) {
                    return $this->redirect($this->service->next_filling($stay));
                } else {
                    return $this->redirect(['/stay/services', 'id' => $stay->id]);
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
                $services = [];

                if (isset($params['services'])) {
                    $_services = $params['services'];
                    foreach ($_services as $i => $item) {
                        $new_service = CustomServices::create($item[0], $item[1], $item[2]);
                        $services[] = $new_service;
                    }
                }
                if ($params['status'] == "add")
                    $services[] = CustomServices::create('', 0, 0);
                return $this->render('_services_list', [
                    'services' => $services,
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