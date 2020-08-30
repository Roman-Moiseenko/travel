<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\services\manage\UserManageService;
use yii\filters\AccessControl;
use yii\web\Controller;

class WishlistController extends Controller
{
    /**
     * @var UserManageService
     */
    private $service;

    public function __construct($id, $module, UserManageService $service, $config = [])
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

    public function actionAddTour($id)
    {
        if (\Yii::$app->user->isGuest) {
            \Yii::$app->session->setFlash('error', Lang::t('Авторизуйтесь для добавления в избранное') . '.');
        } else {
            try {
                $user_id = \Yii::$app->user->id;
                $this->service->addWishilstTour($user_id, $id);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(\Yii::$app->request->referrer);
            }

        }
        return $this->redirect(\Yii::$app->request->referrer);
    }
}