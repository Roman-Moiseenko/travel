<?php


namespace admin\controllers\tour;


use booking\forms\booking\tours\CapacityForm;
use booking\forms\booking\tours\ExtraTimeForm;
use booking\forms\booking\tours\TransferForm;
use booking\services\admin\UserManageService;
use booking\services\booking\tours\TourService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\web\Controller;

class GeneralController extends Controller
{
    public $layout = 'main';
    /**
     * @var TourService
     */
    private $service;
    private $user;
    /**
     * @var UserManageService
     */
    private $userService;

    public function __construct(
        $id,
        $module,
        TourService $service,
        LoginService $loginService,
        UserManageService $userService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->user = $loginService->admin();
        $this->userService = $userService;
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
        return $this->render('index', [
            'model_extra_time' => new ExtraTimeForm(),
            'model_capacity' => new CapacityForm(),
            'model_transfer' => new TransferForm(),
            'user' => $this->user,
        ]);
    }

    public function actionExtraTime()
    {
        $form = new ExtraTimeForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $count = $this->service->setExtraTime($this->user->getId(), $form);
                \Yii::$app->session->setFlash('success', 'Успешно применено для ' . $count . ' экскурсий');
                return $this->redirect(['/tour/general']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model_extra_time' => $form,
            'model_capacity' => new CapacityForm(),
            'model_transfer' => new TransferForm(),
            'user' => $this->user,
        ]);
    }

    public function actionCreateCapacity()
    {
        $form = new CapacityForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->userService->addCapacity($this->user->getId(), $form);
                \Yii::$app->session->setFlash('success', 'Успех');
                return $this->redirect(['/tour/general']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model_extra_time' => new ExtraTimeForm(),
            'model_capacity' => $form,
            'model_transfer' => new TransferForm(),
            'user' => $this->user,
        ]);
    }

    public function actionRemoveCapacity()
    {
        try {
            $id = \Yii::$app->request->bodyParams['id'];
            $this->userService->removeCapacity($this->user->getId(), $id);
            \Yii::$app->session->setFlash('success', 'Успех');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/tour/general']);
    }

    public function actionSetCapacity()
    {
        try {
            $id = \Yii::$app->request->bodyParams['id'];
            $count = $this->service->setCapacity($this->user->getId(), $id);
            \Yii::$app->session->setFlash('success', 'Успешно применено для ' . $count . ' экскурсий');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/tour/general']);
    }

    public function actionCreateTransfer()
    {
        $form = new TransferForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->userService->addTransfer($this->user->getId(), $form);
                \Yii::$app->session->setFlash('success', 'Успех');
                return $this->redirect(['/tour/general']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model_extra_time' => new ExtraTimeForm(),
            'model_capacity' => $form,
            'model_transfer' => new TransferForm(),
            'user' => $this->user,
        ]);
    }
    public function actionSetTransfer()
    {
        try {
            $id = \Yii::$app->request->bodyParams['id'];
            $cost = \Yii::$app->request->bodyParams['cost'];
            $this->userService->costTransfer($this->user->getId(), $id, $cost);
            //\Yii::$app->session->setFlash('success', 'Успешно применено для ' . $count . ' экскурсий');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/tour/general']);
    }

    public function actionRemoveTransfer()
    {
        try {
            $id = \Yii::$app->request->bodyParams['id'];
            $this->userService->removeTransfer($this->user->getId(), $id);
            \Yii::$app->session->setFlash('success', 'Успех');
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['/tour/general']);
    }
}