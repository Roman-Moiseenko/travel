<?php


namespace admin\controllers\fun;

use booking\entities\booking\funs\Fun;
use booking\forms\booking\funs\FunParamsForm;
use booking\helpers\scr;
use booking\services\booking\funs\FunService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ParamsController extends Controller
{
    public  $layout = 'main-funs';
    private $service;

    public function __construct($id, $module, FunService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
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

    public function actionIndex($id)
    {
        $fun = $this->findModel($id);

        return $this->render('view', [
            'fun' => $fun,
        ]);
    }

    public function actionUpdate($id)
    {
        $fun = $this->findModel($id);
        $form = new FunParamsForm($fun);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setParams($fun->id, $form);
                return $this->redirect(['/fun/params', 'id' => $fun->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'fun' => $fun,
            'model' => $form,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Fun::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного Развлечения');
            }
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}