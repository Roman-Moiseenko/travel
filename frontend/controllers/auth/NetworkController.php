<?php


namespace frontend\controllers\auth;


//use common\auth\Identity;

use booking\helpers\scr;
use booking\services\NetworkService;
use Yii;
use yii\authclient\ClientInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\authclient\AuthAction;

class NetworkController extends Controller
{
    /**
     * @var NetworkService
     */
    private  $networkService;
    private $link;

    public function __construct($id, $module, NetworkService $networkService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->networkService = $networkService;
       /* $session = \Yii::$app->session;
        if ($session->isActive) {
            $this->link = $session->get('link');
            $session->remove('link');
        } else {
            $this->link = '/about';
        }*/
    }

    public function actions()
    {

        $session = \Yii::$app->session;
        if ($session->isActive) {
            $returnLink = $session->get('link');
            $session->remove('link');
        } else {
            $returnLink = '/about';
        }
        $returnLink = '/about';
        return [
            'auth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
                'successUrl' => Url::to([$returnLink], true),
                'cancelUrl' => Url::to(['/login'], true),
            ],
        ];
    }

    public function onAuthSuccess(ClientInterface $client) //: void
    {
        $network = $client->getId();
        $attributes = $client->getUserAttributes();
        //$client->getName();
        $identity = ArrayHelper::getValue($attributes, 'id');
        $email = $attributes['email'] ?? null;
        try {
            $user = $this->networkService->auth($network, $identity, $email);
            \Yii::$app->user->login($user, \Yii::$app->params['user.rememberMeDuration']);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

}