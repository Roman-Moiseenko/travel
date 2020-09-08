<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\repositories\booking\WishlistRepository;
use booking\services\manage\UserManageService;
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

    public function actionAddTour($id)
    {
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $user_id = \Yii::$app->user->id;
                $this->service->addWishilstTour($user_id, $id);
                \Yii::$app->session->setFlash('success', Lang::t('Успешно добавлено в избранное'));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }

        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionIndex()
    {
        $wishlist = $this->wishlist->getAll(\Yii::$app->user->id);
        return $this->render('index', [
            'wishlist' => $wishlist,
        ]);
    }

    public function actionDelTour($id)
    {
        try {
            $user_id = \Yii::$app->user->id;
            $this->service->removeWishilstTour($user_id, $id);
            \Yii::$app->session->setFlash('success', Lang::t('Успешное удаление из избранного'));
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }
}