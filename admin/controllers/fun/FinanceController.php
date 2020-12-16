<?php

namespace admin\controllers\fun;

use booking\entities\booking\funs\Fun;
use booking\forms\booking\funs\FunFinanceForm;
use booking\repositories\booking\funs\FunRepository;
use booking\services\booking\funs\FunService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FinanceController extends Controller
{
    public $layout = 'main-funs';
    /**
     * @var FunService
     */
    private $service;
    /**
     * @var FunRepository
     */
    private $funs;


    public function __construct(
        $id,
        $module,
        FunService $service,
        FunRepository $funs,
        $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->funs = $funs;
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
        $form = new FunFinanceForm($fun);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->setFinance($fun->id, $form);
                return $this->redirect(['/fun/finance', 'id' => $fun->id]);
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

    public function actionTimes()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            if (!isset($params['type_time'])) return '';
            $fun = $this->findModel($params['fun_id']);
            if ($params['type_time'] == Fun::TYPE_TIME_EXACT) $view = '_time_exact';
            if ($params['type_time'] == Fun::TYPE_TIME_EXACT_FULL) $view = '_time_exact_full';
            if ($params['type_time'] == Fun::TYPE_TIME_INTERVAL) $view = '_time_interval';
            if (!isset($view)) return '';
            return $this->render($view, ['times' => $fun->times]);
        }
    }

    public function actionRenderTimes()
    {
        if (\Yii::$app->request->isAjax) {
            $this->layout = 'main_ajax';
            $params = \Yii::$app->request->bodyParams;
            if ($params['type_time'] == Fun::TYPE_TIME_EXACT) $view = '_time_exact';
            if ($params['type_time'] == Fun::TYPE_TIME_EXACT_FULL) $view = '_time_exact_full';
            if ($params['type_time'] == Fun::TYPE_TIME_INTERVAL) $view = '_time_interval';
            if (!isset($view)) return '';

            if (isset($params['times']) && $params['type_time'] != Fun::TYPE_TIME_INTERVAL)
                usort($params['times'], function ($a, $b) {
                    if ($a['begin'] > $b['begin']) {
                        return 1;
                    } else {
                        return -1;
                    }
                });

            return $this->render($view, ['times' => $params['times'] ?? []]);
        }
    }

    public function actionGetTimes()
    {
        if (\Yii::$app->request->isAjax) {
            $params = \Yii::$app->request->bodyParams;
            $fun = $this->findModel($params['fun_id']);
            $result = [];
            foreach ($fun->times as $time) {
                $result[] = ['begin' => $time->begin, 'end' => $time->end];
            }
            return json_encode($result);
        }
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