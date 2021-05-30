<?php


namespace frontend\controllers\cabinet;


use booking\entities\Lang;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\message\ConversationForm;
use booking\forms\message\DialogForm;
use booking\helpers\scr;
use booking\repositories\message\DialogRepository;
use booking\services\DialogService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\web\Controller;

class DialogController extends Controller
{
    public $layout = 'cabinet';
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
        $config = [])
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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dialogs = $this->dialogs->getByUser($this->loginService->user()->getId());
        return $this->render('index', [
            'dialogs' => $dialogs,
        ]);
    }

    /** @var $id string .... код-бронирования */
    public function actionDialog($id)
    {
        $dialog = $this->dialogs->findByOptional($id);
        if ($dialog) {
          $this->redirect(['/cabinet/dialog/conversation',  'id' => $dialog->id]);
        } else {
            $form = new DialogForm();
            if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
                try {
                    $admin_id = substr($id, 0, strpos($id, '.'));
                    $dialog = $this->service->create(
                        $this->loginService->user()->getId(),
                        Dialog::CLIENT_PROVIDER,
                        $id,
                        $form,
                        $admin_id
                        );
                    $this->redirect(['/cabinet/dialog/conversation',  'id' => $dialog->id]);
                } catch (\DomainException $e) {
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
            return $this->render('create', [
                'model' => $form,
                'typeDialog' => Dialog::CLIENT_PROVIDER,
                'optional' => $id,
            ]);
        }
    }

    public function actionConversation($id)
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

    public function actionSupport()
    {
        $form = new DialogForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $dialog = $this->service->create(
                    $this->loginService->user()->getId(),
                    Dialog::CLIENT_SUPPORT,
                    null,
                    $form,
                    null
                );
                $this->redirect(['/cabinet/dialog/conversation',  'id' => $dialog->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'typeDialog' => Dialog::CLIENT_SUPPORT,
            'optional' => null,
        ]);
    }

    public function actionPetition($id)
    {
        try {
            $this->service->petition(ThemeDialog::PETITION_PROVIDER, Dialog::CLIENT_SUPPORT, $id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        \Yii::$app->session->setFlash('success', Lang::t('Жалоба подана. Ожидайте решение службы поддержки') . '.');
        return $this->redirect(\Yii::$app->request->referrer);
    }
}