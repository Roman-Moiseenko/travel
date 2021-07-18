<?php


namespace admin\controllers\trip;


use booking\entities\booking\Meals;
use booking\entities\booking\trips\placement\Placement;
use booking\entities\booking\trips\placement\room\Room;
use booking\entities\booking\trips\Trip;
use booking\forms\booking\PhotosForm;
use booking\forms\booking\trips\MealAssignForm;
use booking\forms\booking\trips\MealsForm;
use booking\forms\booking\trips\PlacementForm;
use booking\forms\booking\trips\RoomForm;
use booking\helpers\Filling;
use booking\repositories\booking\trips\placement\PlacementRepository;
use booking\services\booking\trips\PlacementService;
use booking\services\booking\trips\RoomService;
use booking\services\booking\trips\TripService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PlacementController extends Controller
{
    public $layout = 'main-trips';
    private $serviceTrip;
    private $servicePlacement;
    /**
     * @var PlacementRepository
     */
    private $placements;
    private $user_id;
    /**
     * @var RoomService
     */
    private $serviceRoom;

    public function __construct(
        $id,
        $module,
        TripService $serviceTrip,
        PlacementService $servicePlacement,
        PlacementRepository $placements,
        RoomService $serviceRoom,
        LoginService $loginService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->serviceTrip = $serviceTrip;
        $this->servicePlacement = $servicePlacement;
        $this->placements = $placements;
        $this->user_id = $loginService->admin()->getId();
        $this->serviceRoom = $serviceRoom;
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'delete-photo' => ['POST'],
                    'move-photo-up' => ['POST'],
                    'move-photo-down' => ['POST'],
                    'featured' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::PLACEMENT) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->serviceTrip->redirect_filling($trip));
            }
        $placements = $this->placements->getByUser($this->user_id);
        return $this->render('index', [
            'trip' => $trip,
            'placements' => $placements,
        ]);
    }

    public function actionAssign($id, $placement_id, $set)
    {
        if ($set == 1) {
            $this->serviceTrip->assignPlacement($id, $placement_id);
        } else {
            $this->serviceTrip->revokePlacement($id, $placement_id);
        }
        //return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCreate($id) //trip_id
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::PLACEMENT) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->serviceTrip->redirect_filling($trip));
            }
        $form = new PlacementForm();

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $placement = $this->servicePlacement->create($form);
                return $this->redirect(Url::to(['/trip/placement/view', 'id' => $trip->id, 'placement_id' => $placement->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'trip' => $trip,
        ]);
    }

    public function actionUpdate($id, $placement_id) //trip_id
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::PLACEMENT) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->serviceTrip->redirect_filling($trip));
            }
        $placement = $this->placements->get($placement_id);
        $form = new PlacementForm($placement);

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->servicePlacement->edit($placement_id, $form);
                return $this->redirect(Url::to(['/trip/placement/view', 'id' => $trip->id, 'placement_id' => $placement->id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'trip' => $trip,
            'placement' => $placement,
        ]);
    }

    public function actionView($id, $placement_id) //placement_id
    {
        $trip = $this->findModel($id);
        $placement = $this->placements->get($placement_id);

        if ($trip->filling)
            if ($trip->filling == Filling::PLACEMENT) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->serviceTrip->redirect_filling($trip));
            }
        return $this->render('view', [
            'trip' => $trip,
            'placement' => $placement,
        ]);
    }

    public function actionRooms($id, $placement_id, $room_id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::PLACEMENT) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->serviceTrip->redirect_filling($trip));
            }
        $placement = $this->placements->get($placement_id);

        $form = new RoomForm($room_id == -1 ? null : Room::findOne($room_id));
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                if ($room_id == -1) {
                    $this->serviceRoom->create($placement_id, $form);
                } else {
                    $this->serviceRoom->edit($room_id, $form);
                }
                return $this->redirect(Url::to(['/trip/placement/view', 'id' => $trip->id, 'placement_id' => $placement_id]));

            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('rooms', [
            'model' => $form,
            'trip' => $trip,
            'placement' => $placement,
            'room' => $room_id == -1 ? null : Room::findOne($room_id),
        ]);
    }

    public function actionMeals($id, $placement_id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::PLACEMENT) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->serviceTrip->redirect_filling($trip));
            }
        $placement = $this->placements->get($placement_id);
        $form = new MealsForm($placement);
        //$meals = Meals::find()->orderBy(['sort' => SORT_ASC])->all();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->servicePlacement->assignMeals($placement_id, $form);
                return $this->redirect(Url::to(['/trip/placement/view', 'id' => $trip->id, 'placement_id' => $placement_id]));

            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('meals', [
            'model' => $form,
            'trip' => $trip,
            'placement' => $placement,
        ]);
    }

    public function actionPhoto($id, $placement_id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling)
            if ($trip->filling == Filling::PLACEMENT) {
                $this->layout = 'main-create';
            } else {
                return $this->redirect($this->serviceTrip->redirect_filling($trip));
            }
        $placement = $this->placements->get($placement_id);

        $form = new PhotosForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->servicePlacement->addPhotos($placement_id, $form);
                return $this->redirect(Url::to(['/trip/placement/view', 'id' => $trip->id, 'placement_id' => $placement_id]));

            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('photo', [
            'placement' => $placement,
            'model' => $form,
            'trip' => $trip,
        ]);
    }

    public function actionDeletePhoto($id, $photo_id)
    {
        try {
            $this->servicePlacement->removePhoto($id, $photo_id);

        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->servicePlacement->movePhotoUp($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->servicePlacement->movePhotoDown($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionRoomDeletePhoto($id, $photo_id)
    {
        try {
            $this->serviceRoom->removePhoto($id, $photo_id);

        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionRoomMovePhotoUp($id, $photo_id)
    {
        $this->serviceRoom->movePhotoUp($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionRoomMovePhotoDown($id, $photo_id)
    {
        $this->serviceRoom->movePhotoDown($id, $photo_id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionFilling($id)
    {
        $trip = $this->findModel($id);
        if ($trip->filling && $trip->filling == Filling::PLACEMENT) return $this->redirect($this->serviceTrip->next_filling($trip));
    }

    protected function findModel($id)
    {
        if (($model = Trip::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного тура');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}