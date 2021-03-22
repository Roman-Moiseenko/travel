<?php


namespace admin\controllers\stay;

use admin\widgest\report\ChartMoneyWidget;
use admin\widgest\report\ChartWidget;
use admin\widgest\report\PaymentNextWidget;
use admin\widgest\report\PaymentPastWidget;
use admin\widgest\report\StaticWidget;
use booking\entities\booking\cars\Car;
use booking\entities\booking\stays\Stay;
use booking\forms\admin\ChartForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReportController extends Controller
{
    public $layout = 'main-stays';

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
        $form = new ChartForm();
        $stay = $this->findModel($id);
        $form->load(\Yii::$app->request->post());

        return $this->render('index', [
            'form' => $form,
            'stay' => $stay,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Stay::findOne($id)) !== null) {
            if ($model->user_id != \Yii::$app->user->id) {
                throw new \DomainException('У вас нет прав для данного жилища');
            }
            return $model;
        }
        throw new NotFoundHttpException('Жилище не найдено ID=' . $id);
    }


}