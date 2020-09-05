<?php


namespace admin\controllers;


use admin\forms\DiscountSearch;
use booking\entities\booking\Discount;
use booking\forms\booking\DiscountForm;
use booking\helpers\scr;
use booking\repositories\admin\UserRepository;
use booking\repositories\booking\DiscountRepository;
use booking\services\admin\UserManageService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DiscountController extends Controller
{


    /**
     * @var DiscountRepository
     */
    private $discounts;
    /**
     * @var UserManageService
     */
    private $service;
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct($id, $module, DiscountRepository $discounts, UserManageService $service, UserRepository $users, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->discounts = $discounts;
        $this->service = $service;
        $this->users = $users;
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

    public function actionIndex()
    {
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionCreate()
    {
        $form = new DiscountForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            //scr::p(\Yii::$app->request->post());
            try {
                $this->service->addDiscount(\Yii::$app->user->id, $form);
                return $this->redirect(['/discount']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionDraft($id)
    {
        try {
            $this->service->draftDiscount(\Yii::$app->user->id, $id);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionLoad()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams['set'];
            if ($params == '') return '';
            if ($params == Discount::E_ADMIN_USER) return '<option value="0">Все</option>';
            $user = $this->users->get(\Yii::$app->user->id);
            if ($params == Discount::E_USER_LEGAL) {
                $result = '';
                $legals = $user->legals;
                foreach ($legals as $legal) {
                    $result .= '<option value="' . $legal->id . '">' . $legal->caption . ' (' . $legal->name . ')' . '</option>';
                }
                return $result;
            }
            if ($params == Discount::E_BOOKING_TOUR) {
                    $result = '<option value="0">Все</option>';
                    $tours = $user->tours;
                    foreach ($tours as $tour) {
                        $result .= '<option value="' . $tour->id . '">' . $tour->name . '</option>';
                    }
                    return $result;
            }
            if ($params == Discount::E_BOOKING_STAY) {
                $result = '<option value="0">Все</option>';
                $stays = $user->stays;
                foreach ($stays as $stay) {
                    $result .= '<option value="' . $stay->id . '">' . $stay->name . '</option>';
                }
                return $result;
            }
            if ($params == Discount::E_BOOKING_CAR) {
                $result = '<option value="0">Все</option>';
                $cars = $user->cars;
                foreach ($cars as $car) {
                    $result .= '<option value="' . $car->id . '">' . $car->name . '</option>';
                }
                return $result;
            }
        }
    }
}