<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\repositories\booking\WishlistRepository;
use booking\services\system\LoginService;
use booking\services\user\UserManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

class WishlistController extends Controller
{
    public $layout = 'cabinet';
    /**
     * @var UserManageService
     */
    private $service;
    /**
     * @var WishlistRepository
     */
    private $wishlist;

    private $isGuest;
    private $userId;

    public function __construct(
        $id,
        $module,
        UserManageService $service,
        WishlistRepository $wishlist,
        LoginService $loginService,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->wishlist = $wishlist;
        $this->isGuest = $loginService->isGuest();
        $this->userId = $loginService->user() ? $loginService->user()->getId() : null;
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
        if ($this->isGuest) return $this->goHome();
        $wishlist = $this->wishlist->getAll($this->userId);
        return $this->render('index', [
            'wishlist' => $wishlist,
        ]);
    }

    public function actionAddTour($id)
    {
        if ($this->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $this->service->addWishlistTour($this->userId, $id);
                \Yii::$app->session->setFlash('success', Lang::t('Успешно добавлено в избранное'));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelTour($id)
    {
        if ($this->isGuest) return $this->goHome();
        try {
            $this->service->removeWishlistTour($this->userId, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddCar($id)
    {
        if ($this->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $this->service->addWishlistCar($this->userId, $id);
                \Yii::$app->session->setFlash('success', Lang::t('Успешно добавлено в избранное'));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelCar($id)
    {
        if ($this->isGuest) return $this->goHome();
        try {
            $this->service->removeWishlistCar($this->userId, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddFun($id)
    {
        if ($this->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $this->service->addWishlistFun($this->userId, $id);
                \Yii::$app->session->setFlash('success', Lang::t('Успешно добавлено в избранное'));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelFun($id)
    {
        if ($this->isGuest) return $this->goHome();
        try {
            $this->service->removeWishlistFun($this->userId, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddStay($id)
    {
        if ($this->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $this->service->addWishlistStay($this->userId, $id);
                \Yii::$app->session->setFlash('success', Lang::t('Успешно добавлено в избранное'));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }

        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelStay($id)
    {
        if ($this->isGuest) return $this->goHome();
        try {
            $this->service->removeWishlistStay($this->userId, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddFood($id)
    {
        if ($this->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $this->service->addWishlistFood($this->userId, $id);
                \Yii::$app->session->setFlash('success', Lang::t('Успешно добавлено в избранное'));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelFood($id)
    {
        if ($this->isGuest) return $this->goHome();
        try {
            $this->service->removeWishlistFood($this->userId, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }


    public function actionAddProduct($id)
    {
        if ($this->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $this->service->addWishlistProduct($this->userId, $id);
                \Yii::$app->session->setFlash('success', Lang::t('Успешно добавлено в избранное'));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelProduct($id)
    {
        if ($this->isGuest) return $this->goHome();
        try {
            $this->service->removeWishlistProduct($this->userId, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }
    //TODO ** BOOKING_OBJECT **
}