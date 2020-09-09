<?php


namespace admin\controllers\cabinet;


use booking\entities\admin\user\User;
use booking\entities\Lang;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\message\ConversationForm;
use booking\repositories\DialogRepository;
use booking\services\DialogService;
use yii\filters\AccessControl;
use yii\web\Controller;

class DialogController extends Controller
{
    public $layout = 'main-cabinet';
    private $service;
    private $dialogs;

    public function __construct($id, $module, DialogRepository $dialogs, DialogService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->dialogs = $dialogs;
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
        $dialogs = $this->dialogs->getByAdmin(\Yii::$app->user->id);
        return $this->render('index', [
            'dialogs' => $dialogs,
        ]);
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
        ]);
    }

    public function actionPetition($id)
    {
        try {
            $this->service->petition(ThemeDialog::PETITION_REVIEW, Dialog::PROVIDER_SUPPORT, $id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        \Yii::$app->session->setFlash('success', Lang::t('Жалоба подана. Ожидайте решение службы поддержки') . '.');
        return $this->redirect(\Yii::$app->request->referrer);
    }

    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }
}