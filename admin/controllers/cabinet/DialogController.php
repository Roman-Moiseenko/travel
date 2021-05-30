<?php


namespace admin\controllers\cabinet;

use booking\entities\admin\User;
use booking\entities\booking\cars\CostCalendar;
use booking\entities\Lang;
use booking\entities\message\Conversation;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use booking\forms\message\ConversationForm;
use booking\forms\message\DialogForm;
use booking\helpers\BookingHelper;
use booking\repositories\message\DialogRepository;
use booking\services\DialogService;
use booking\services\system\LoginService;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class DialogController extends Controller
{
    public $layout = 'main-cabinet';
    private $service;
    private $dialogs;
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
        $this->service = $service;
        $this->dialogs = $dialogs;
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
        $dialogs = $this->dialogs->getByAdmin(\Yii::$app->user->id);
        return $this->render('index', [
            'dialogs' => $dialogs,
        ]);
    }

    public function actionDialog($id)
    {
        $dialog = $this->dialogs->findByOptional($id);
        if ($dialog) {
            $this->redirect(['/cabinet/dialog/conversation', 'id' => $dialog->id]);
        } else {
            $form = new DialogForm();
            if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
                try {
                    $booking = BookingHelper::getByNumber($id);
                    $dialog = $this->service->create(
                        $booking->getUserId(),
                        Dialog::CLIENT_PROVIDER,
                        $id,
                        $form,
                        \Yii::$app->user->id
                    );
                    $this->redirect(['/cabinet/dialog/conversation', 'id' => $dialog->id]);
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

    public function actionSupport()
    {
        $form = new DialogForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $dialog = $this->service->create(
                    null,
                    Dialog::PROVIDER_SUPPORT,
                    null,
                    $form,
                    \Yii::$app->user->id
                );
                $this->redirect(['/cabinet/dialog/conversation', 'id' => $dialog->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'typeDialog' => Dialog::PROVIDER_SUPPORT,
            'optional' => null,
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
            'currentUser' => $this->loginService->currentClass(),
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

    public function actionMassCar($id)
    {
        $form = new DialogForm();
        $calendar = CostCalendar::findOne($id);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                foreach ($calendar->bookings as $booking) {
                    $this->service->create(
                        $booking->getUserId(),
                        Dialog::CLIENT_PROVIDER,
                        BookingHelper::number($booking),
                        $form,
                        \Yii::$app->user->id
                    );
                }
                \Yii::$app->session->setFlash('success', 'Сообщение было отправлено ' . count($calendar->bookings) .' клиентам');
                return $this->redirect(Url::to(['car/common', 'id' => $calendar->car_id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-mass', [
            'model' => $form,
            'typeDialog' => Dialog::CLIENT_PROVIDER,
        ]);
    }

    public function actionMassTour($id)
    {
        $form = new DialogForm();
        $calendar = \booking\entities\booking\tours\CostCalendar::findOne($id);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                foreach ($calendar->bookings as $booking) {
                    $this->service->create(
                        $booking->getUserId(),
                        Dialog::CLIENT_PROVIDER,
                        BookingHelper::number($booking),
                        $form,
                        \Yii::$app->user->id
                    );
                }
                \Yii::$app->session->setFlash('success', 'Сообщение было отправлено ' . count($calendar->bookings) .' клиентам');
                return $this->redirect(Url::to(['tour/common', 'id' => $calendar->tours_id]));
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-mass', [
            'model' => $form,
            'typeDialog' => Dialog::CLIENT_PROVIDER,
        ]);
    }
}