<?php


namespace office\controllers;


use booking\entities\Rbac;
use booking\repositories\user\UserRepository;
use booking\services\user\UserManageService;
use office\forms\ClientsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ClientsController extends Controller
{

    /**
     * @var UserManageService
     */
    private $service;
    /**
     * @var UserRepository
     */
    private $users;

    public function __construct($id, $module, UserManageService $service, UserRepository $users, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->users = $users;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_MANAGER],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $user = $this->users->get($id);
        return $this->render('view', [
            'user' => $user,
        ]);
    }
    public function actionForum()
    {

        if (\Yii::$app->request->isAjax) {
            try {
                $params = \Yii::$app->request->bodyParams;
                $id = (int)$params['user_id'];
                $role = (int)$params['role'];
                $this->service->setForumRole($id, $role);
                return 'success';
            } catch (\Throwable $e) {
                return $e->getMessage();
            }

        } else {
            return 'нет доступа';
        }
    }
}