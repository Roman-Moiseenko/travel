<?php


namespace office\controllers\dialogs;


use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\entities\Rbac;
use booking\forms\message\ConversationForm;
use booking\forms\message\DialogForm;
use booking\helpers\DiscountHelper;
use booking\repositories\message\DialogRepository;
use booking\services\DialogService;
use office\forms\DialogsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class OtherController extends Controller
{

    /**
     * @var DialogRepository
     */
    private $dialogs;
    /**
     * @var DialogService
     */
    private $service;

    public function __construct($id, $module, DialogRepository $dialogs, DialogService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->dialogs = $dialogs;
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



    public function actionView($id)
    {

        $dialog = $this->dialogs->get($id);
        $conversations = $dialog->conversations;
        usort($conversations, function (Conversation $a, Conversation $b) {
            if ($a->created_at > $b->created_at) return -1;
            return 1;
        });
        return $this->render('view', [
            'dialog' => $dialog,
            'conversations' => $conversations,
        ]);
    }


    public function actionIndex()
    {
        $searchModel = new DialogsSearch([
            'typeDialog' => Dialog::CLIENT_PROVIDER,
        ]);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}