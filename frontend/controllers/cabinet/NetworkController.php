<?php


namespace frontend\controllers\cabinet;

use booking\entities\Lang;
use booking\helpers\scr;
use booking\services\NetworkService;
use booking\services\system\LoginService;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class NetworkController extends Controller
{
    /**
     * @var NetworkService
     */
    private  $networkService;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct($id, $module, NetworkService $networkService, LoginService $loginService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->networkService = $networkService;
        $this->loginService = $loginService;
    }

    public function actions()
    {
        return [
            'attach' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client): void
    {
        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        $identity = ArrayHelper::getValue($attributes, 'id');
        try {
            $this->networkService->attach($this->loginService->user()->getId(), $network, $identity);
            \Yii::$app->session->setFlash('success', Lang::t('Соцсеть была привязана к текущему профилю.'));
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }

    }

    public function actionDisconnect()
    {
        if (\Yii::$app->request->isGet) {
            try {
                $network = \Yii::$app->request->queryParams['network'];
                $identity = \Yii::$app->request->queryParams['identity'];
                $this->networkService->disconnect($this->loginService->user()->getId(), $network, $identity);
                \Yii::$app->session->setFlash('success', Lang::t('Соцсеть была отсоединена от текущего профиля.'));
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

}