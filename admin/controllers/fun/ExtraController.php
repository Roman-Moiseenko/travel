<?php


namespace admin\controllers\fun;

use admin\forms\funs\ExtraSearch;
use booking\entities\booking\funs\Fun;
use booking\forms\booking\funs\ExtraForm;
use booking\repositories\booking\funs\ExtraRepository;
use booking\services\booking\funs\ExtraService;
use booking\services\booking\funs\FunService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ExtraController extends Controller
{
    public  $layout = 'main-funs';
    private $service;
    /**
     * @var ExtraRepository
     */
    private $extra;
    /**
     * @var ExtraService
     */
    private $extraService;

    public function __construct($id, $module, FunService $service, ExtraRepository $extra, ExtraService $extraService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->extra = $extra;
        $this->extraService = $extraService;
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
        $searchModel = new ExtraSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'fun' => $fun,
        ]);
    }


    public function actionSetextra($fun_id, $extra_id, $set = false)
    {
        $this->service->setExtra($fun_id, $extra_id, $set);
    }



    public function actionCreate($id)
    {
        $fun = $this->findModel($id);
        $form = new ExtraForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->extraService->create($fun->user_id, $form);
                return $this->redirect(['/fun/extra', 'id' => $fun->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'fun' => $fun,
            'model' => $form,
        ]);
    }
    public function actionUpdate($id, $extra_id)
    {
        $fun = $this->findModel($id);
        $extra = $this->extra->get($extra_id);
        $form = new ExtraForm($extra);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->extraService->edit($extra->id, $form);
                return $this->redirect(['/fun/extra', 'id' => $fun->id]);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'fun' => $fun,
            'extra' => $extra,
            'model' => $form,
        ]);
    }

    public function actionDelete($id, $extra_id)
    {
        $fun = $this->findModel($id);
        $this->extraService->remove($extra_id);
        return $this->redirect(['/fun/extra', 'id' => $fun->id]);
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