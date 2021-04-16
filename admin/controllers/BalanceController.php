<?php


namespace admin\controllers;


use booking\forms\admin\ToUpBalanceForm;
use booking\repositories\admin\UserRepository;
use booking\services\finance\YKassaService;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class BalanceController extends Controller
{
    public $layout ='main';
    /**
     * @var UserRepository
     */
    private $users;
    /**
     * @var YKassaService
     */
    private $kassa;

    public function __construct($id, $module, UserRepository $users, YKassaService $kassa, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->users = $users;
        $this->kassa = $kassa;
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
        $user_id = \Yii::$app->user->id;

        $dataProviderDeposit = $this->users->searchDeposit($user_id);
        $dataProviderDebiting = $this->users->searchDebiting($user_id);

        return $this->render('index', [
            'dataProviderDeposit' => $dataProviderDeposit,
            'dataProviderDebiting' => $dataProviderDebiting,
            'user' => $this->users->get($user_id),
        ]);
    }

    public function actionUp()
    {
        $user_id = \Yii::$app->user->id;

        $form = new ToUpBalanceForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                return $this->redirect(\Yii::$app->params['frontendHostInfo'] .
                    '/cabinet/yandexkassa/invoice-admin?id=' . $user_id . '&amount=' . $form->amount);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('to-up', [
            'model' => $form,
        ]);
    }

    public function actionDeposit()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $user_id = $params['user_id'];
            $search = $params['search'];
            $dataProviderDeposit = $this->users->searchDeposit($user_id, $search);
            return $this->render('deposit', [
                'dataProviderDeposit' => $dataProviderDeposit,
            ]);
        }
        return $this->goHome();
    }

    public function actionDebiting()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $user_id = $params['user_id'];
            $search = $params['search'];
            $dataProviderDebiting = $this->users->searchDebiting($user_id, $search);
            return $this->render('debiting', [
                'dataProviderDebiting' => $dataProviderDebiting,
            ]);
        }
        return $this->goHome();
    }
}