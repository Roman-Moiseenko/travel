<?php


namespace frontend\controllers\cabinet;


use booking\entities\message\Dialog;
use booking\forms\message\DialogForm;
use booking\helpers\scr;
use booking\repositories\DialogRepository;
use booking\services\DialogService;
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
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dialogs = $this->dialogs->getAdminByUser(\Yii::$app->user->id);
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
                        \Yii::$app->user->id,
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
                'typeDialog' => Dialog::CLIENT_PROVIDER
            ]);
        }
    }

    public function actionNewSupport()
    {
        $form = new DialogForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $dialog = $this->service->create(
                    \Yii::$app->user->id,
                    Dialog::CLIENT_SUPPORT,
                    null,
                    $form
                );
                $this->redirect(['/cabinet/dialog/conversation',  'id' => $dialog->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'typeDialog' => Dialog::CLIENT_SUPPORT
        ]);
    }

    public function actionConversation($id)
    {
        $dialog = $this->dialogs->get($id);

        return $this->render('conversation', [
            'dialog' => $dialog,
        ]);
    }


    public function actionSupport()
    {
        $dialogs = $this->dialogs->getSupportUser(\Yii::$app->user->id);
        return $this->render('support', [
            'dialogs' => $dialogs,
        ]);
    }
}