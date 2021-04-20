<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\repositories\booking\WishlistRepository;
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

    public function __construct($id, $module, UserManageService $service, WishlistRepository $wishlist, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->wishlist = $wishlist;
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
        $wishlist = $this->wishlist->getAll(\Yii::$app->user->id);
        return $this->render('index', [
            'wishlist' => $wishlist,
        ]);
    }

    public function actionAddTour($id)
    {
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $user_id = \Yii::$app->user->id;
                $this->service->addWishlistTour($user_id, $id);
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
        try {
            $user_id = \Yii::$app->user->id;
            $this->service->removeWishlistTour($user_id, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddCar($id)
    {
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $user_id = \Yii::$app->user->id;
                $this->service->addWishlistCar($user_id, $id);
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
        try {
            $user_id = \Yii::$app->user->id;
            $this->service->removeWishlistCar($user_id, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddFun($id)
    {
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $user_id = \Yii::$app->user->id;
                $this->service->addWishlistFun($user_id, $id);
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
        try {
            $user_id = \Yii::$app->user->id;
            $this->service->removeWishlistFun($user_id, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddStay($id)
    {
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $user_id = \Yii::$app->user->id;
                $this->service->addWishlistStay($user_id, $id);
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
        try {
            $user_id = \Yii::$app->user->id;
            $this->service->removeWishlistStay($user_id, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionAddFood($id)
    {
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $user_id = \Yii::$app->user->id;
                $this->service->addWishlistFood($user_id, $id);
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
        try {
            $user_id = \Yii::$app->user->id;
            $this->service->removeWishlistFood($user_id, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }


    public function actionAddProduct($id)
    {
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $user_id = \Yii::$app->user->id;
                $this->service->addWishlistProduct($user_id, $id);
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
        try {
            $user_id = \Yii::$app->user->id;
            $this->service->removeWishlistProduct($user_id, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }
    //TODO ** BOOKING_OBJECT **
}