<?php


namespace office\controllers\finance;


use booking\entities\admin\Legal;
use booking\entities\finance\Payment;
use booking\entities\Rbac;
use booking\helpers\scr;
use booking\services\finance\PaymentService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ProviderController extends Controller
{
    /**
     * @var PaymentService
     */
    private $service;

    public function __construct($id, $module, PaymentService $service, $config = [])
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


    public function actionIndex()
    {
        $deduction = \Yii::$app->params['deduction'];
        $payments = Payment::find()
            ->alias('p')
            ->andWhere(['status' => Payment::STATUS_NEW])
            ->select('p.legal_id, l.name, l.INN, SUM(amount) as amount')
            ->groupBy(['legal_id'])
            ->innerJoin(Legal::tableName() . ' l', 'l.id = p.legal_id')
            ->asArray()
            ->all();
        foreach ($payments as $i => $payment) {
            $payments[$i]['pay_legal'] = $payment['amount'] * (1 - $deduction/100);
        }
        return $this->render('index', [
            'payments' => $payments,
        ]);
    }

    public function actionView($id)
    {
        $deduction = \Yii::$app->params['deduction'];
        $payments = Payment::find()
            ->andWhere(['status' => Payment::STATUS_NEW])
            ->andWhere(['legal_id' => $id])
            ->all();
        $legal = Legal::findOne($id);
        return $this->render('view', [
            'payments' => $payments,
            'deduction' => $deduction,
            'legal' => $legal,
        ]);
    }

    public function actionPay($id)
    {
     $deduction = \Yii::$app->params['deduction'];
        $payments = Payment::find()
            ->andWhere(['status' => Payment::STATUS_NEW])
            ->andWhere(['legal_id' => $id])
            ->all();
        foreach ($payments as $payment) {
            $this->service->pay($payment->id, $deduction);
        }

        return $this->redirect(\Yii::$app->request->referrer);
    }
}