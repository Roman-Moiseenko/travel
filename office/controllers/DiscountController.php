<?php


namespace office\controllers;


use booking\entities\booking\Discount;
use booking\entities\office\User;
use booking\entities\Rbac;
use booking\forms\booking\DiscountForm;
use booking\services\booking\DiscountService;
use office\forms\DiscountSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class DiscountController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [Rbac::ROLE_ADMIN],
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
        $searchModel = new DiscountSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        $form = new DiscountForm();
        $form->entities = User::class;
        $form->percent = \Yii::$app->params['deduction'];
        $form->count = 500;

        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            //scr::p(\Yii::$app->request->post());
            try {
               // $this->service->addDiscount(\Yii::$app->user->id, $form);
                //TODO Добавляем скидки в Сервис=>

                ini_set('max_execution_time', 30 + $form->repeat * 2);
                for ($i = 1; $i <= $form->repeat; $i++) {
                    $discount = Discount::create(
                        $form->entities,
                        $form->entities_id == 0 ? null : $form->entities_id,
                        DiscountService::generatePromo($form->entities),
                        $form->percent,
                        $form->count
                    );
                    $discount->save();
                    sleep(1);
                }

                ini_set('max_execution_time', 30);

                return $this->redirect(['/discount']);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $form,
        ]);
    }

    public function actionDelete($id)
    {
        $discount = Discount::findOne($id);
        if ($discount->count == $discount->countNotUsed())
        {
            $discount->delete();

        } else {
            \Yii::$app->session->setFlash('error', 'Нельзя удалить уже используемый ПРОМО-код');
        }
        return $this->redirect(['/discount']);
        //TODO Если не применялось, то удалить, иначе => error
    }
}