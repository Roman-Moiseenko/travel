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
use booking\services\system\LoginService;
use office\forms\DialogsSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ClientController extends Controller
{
    /**
     * @var DialogRepository
     */
    private $dialogs;
    /**
     * @var DialogService
     */
    private $service;
    /**
     * @var LoginService
     */
    private $loginService;

    public function __construct(
        $id,
        $module,
        DialogRepository $dialogs,
        DialogService $service,
        LoginService $loginService,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->dialogs = $dialogs;
        $this->service = $service;
        $this->loginService = $loginService;
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
        $form = new ConversationForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addConversation($id, $form);
                $this->redirect(\Yii::$app->request->referrer);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        $dialog = $this->dialogs->get($id);
        $conversations = $dialog->conversations;
        usort($conversations, function (Conversation $a, Conversation $b) {
            if ($a->created_at > $b->created_at) return -1;
            return 1;
        });
        $this->service->readConversation($dialog->id);
        return $this->render('conversation', [
            'dialog' => $dialog,
            'model' => $form,
            'conversations' => $conversations,
            'currentUser' => $this->loginService->currentClass(),
        ]);
    }

    public function actionIndex()
    {
        $searchModel = new DialogsSearch([
            'typeDialog' => Dialog::CLIENT_SUPPORT,
        ]);
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


}