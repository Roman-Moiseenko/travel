<?php


namespace admin\controllers;


use admin\forms\StaffSearch;
use booking\entities\booking\cars\Car;
use booking\entities\booking\tours\Tour;
use booking\entities\check\User;
use booking\forms\check\UserForm;
use booking\helpers\BookingHelper;
use booking\helpers\scr;
use booking\repositories\booking\cars\CarRepository;
use booking\repositories\booking\funs\FunRepository;
use booking\repositories\booking\stays\StayRepository;
use booking\repositories\booking\tours\TourRepository;
use booking\services\check\UserManageService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class StaffController extends Controller
{
    public $layout ='main';
    /**
     * @var UserManageService
     */
    private $service;
    /**
     * @var TourRepository
     */
    private $tours;
    /**
     * @var CarRepository
     */
    private $cars;
    /**
     * @var FunRepository
     */
    private $funs;
    /**
     * @var StayRepository
     */
    private $stays;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        UserManageService $service,
        LoginService $loginService,
        TourRepository $tours,
        CarRepository $cars,
        FunRepository $funs,
        StayRepository $stays,
        //TODO ** BOOKING_OBJECT **
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->tours = $tours;
        $this->cars = $cars;
        $this->funs = $funs;
        $this->stays = $stays;
        $this->loginService = $loginService;
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
        $searchModel = new StaffSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new UserForm();
        if ($form->load(\Yii::$app->request->post()) &&  $form->validate()) {
            try {
                $user = $this->service->create($this->loginService->admin()->getId(), $form);
                return $this->redirect(Url::to(['staff/view', 'id' => $user->id]));
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionView($id)
    {
        $user = \booking\entities\check\User::findOne($id);
        $objects = [];
        $admin_id = $this->loginService->admin()->getId();
        $tours = $this->tours->getByAdminList($admin_id);
        $cars = $this->cars->getByAdminList($admin_id);
        $funs = $this->funs->getByAdminList($admin_id);
        $stays = $this->stays->getByAdminList($admin_id);

        foreach ($tours as $tour) {
            $objects[] = [
                'check' => $user->existObject(BookingHelper::BOOKING_TYPE_TOUR, $tour->id),
                'type' => BookingHelper::BOOKING_TYPE_TOUR,
                'name' => $tour->name,
                'id' => $tour->id
            ];
        }
        foreach ($cars as $car) {
            $objects[] = [
                'check' => $user->existObject(BookingHelper::BOOKING_TYPE_CAR, $car->id),
                'type' => BookingHelper::BOOKING_TYPE_CAR,
                'name' => $car->name,
                'id' => $car->id
            ];
        }

        foreach ($funs as $fun) {
            $objects[] = [
                'check' => $user->existObject(BookingHelper::BOOKING_TYPE_CAR, $fun->id),
                'type' => BookingHelper::BOOKING_TYPE_FUNS,
                'name' => $fun->name,
                'id' => $fun->id
            ];
        }
        foreach ($stays as $stay) {
            $objects[] = [
                'check' => $user->existObject(BookingHelper::BOOKING_TYPE_STAY, $stay->id),
                'type' => BookingHelper::BOOKING_TYPE_STAY,
                'name' => $stay->name,
                'id' => $stay->id
            ];
        }
        //TODO ** BOOKING_OBJECT **

        return $this->render('view', [
            'user' => $user,
            'objects' => $objects,
        ]);
    }

    public function actionUpdate($id)
    {
        $user = \booking\entities\check\User::findOne($id);
        $form = new UserForm($user);
        if ($form->load(\Yii::$app->request->post()) &&  $form->validate()) {
            try {
                $this->service->update($id, $form);
                return $this->redirect(Url::to(['staff/view', 'id' => $user->id]));
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'user' => $user,
            'model' =>$form,
        ]);
    }

    public function actionLock($id)
    {
        $user = User::findOne($id);
        $this->service->lock($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionUnlock($id)
    {
        $user = User::findOne($id);
        $this->service->unlock($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }



    public function actionGetPassword()
    {
        if (\Yii::$app->request->isAjax)
        {
            return \Yii::$app->security->generateRandomString(6);
        }
    }

    public function actionUpdateObject()
    {
        if (\Yii::$app->request->isAjax)
        {
            $params = \Yii::$app->request->bodyParams;
            $status = $params['status'];
            $user_id = $params['user_id'];
            $object_type = $params['type'];
            $object_id = $params['object_id'];
            if ($status=='true') {
                $this->service->addObject($user_id, $object_type, $object_id);
            }
            else {
                $this->service->removeObject($user_id, $object_type, $object_id);
            }
        }
    }

}