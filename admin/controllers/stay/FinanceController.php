<?php


namespace admin\controllers\stay;

use booking\entities\booking\stays\Stay;
use booking\forms\booking\stays\StayFinanceForm;
use booking\repositories\booking\stays\StayRepository;
use booking\services\booking\stays\StayService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FinanceController extends Controller
{
    public $layout = 'main-stays';
    private $service;
    /**
     * @var StayRepository
     */
    private $stays;

    public function __construct(
        $id,
        $module,
        StayService $service,
        StayRepository $stays,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->stays = $stays;
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
        return $this->render('view', [
            'stay' => $stay,
        ]);
    }

    public function actionUpdate($id)
    {
        $stay = $this->findModel($id);
        $form = new StayFinanceForm($stay);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setFinance($stay->id, $form);
                return $this->redirect(['/stay/finance', 'id' => $stay->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'stay' => $stay,
            'model' => $form,
        ]);
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