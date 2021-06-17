<?php


namespace admin\controllers\tour;


use booking\entities\booking\tours\Tour;
use booking\forms\booking\tours\TourFinanceForm;
use booking\helpers\CalendarHelper;
use booking\helpers\scr;
use booking\repositories\booking\tours\CostCalendarRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\services\booking\tours\TourService;
use booking\services\system\LoginService;
use Codeception\PHPUnit\ResultPrinter\HTML;
use DateTime;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\JsExpression;
use yii\web\NotFoundHttpException;

class FinanceController extends Controller
{
    public $layout = 'main-tours';
    private $service;
    /**
     * @var TourRepository
     */
    private $tours;
    private $user_id;

    public function __construct(
        $id,
        $module,
        TourService $service,
        TourRepository $tours,
        LoginService $loginService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->tours = $tours;
        $this->user_id = $loginService->admin()->getId();
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
            'tour' => $tour,
        ]);
    }

    public function actionUpdate($id)
    {
        $tour = $this->findModel($id);
        if ($tour->filling) { $this->layout = 'main-create';}
        $form = new TourFinanceForm($tour);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setFinance($tour->id, $form);
                if ($tour->filling) {
                    \Yii::$app->session->setFlash('success', 'Экскурсия успешно создана! Заполните календарь и отправьте на модерацию с раздела Описание');
                    return $this->redirect($this->service->next_filling($tour));
                } else {
                    return $this->redirect(['/tour/finance', 'id' => $tour->id]);
                }
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'tour' => $tour,
            'model' => $form,
            'user_id' => $this->user_id,
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