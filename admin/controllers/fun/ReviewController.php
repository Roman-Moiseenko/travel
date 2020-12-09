<?php


namespace admin\controllers\fun;

use booking\entities\booking\funs\Fun;
use booking\repositories\booking\funs\ReviewFunRepository;
use booking\services\booking\funs\FunService;
use booking\services\ContactService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ReviewController extends Controller
{
    public  $layout = 'main-funs';
    /**
     * @var FunService
     */
    private $service;
    /**
     * @var ReviewFunRepository
     */
    private $reviews;
    /**
     * @var ContactService
     */
    private $contact;


    public function __construct($id, $module, FunService $service, ReviewFunRepository $reviews,ContactService $contact, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $service;
        $this->reviews = $reviews;
        $this->contact = $contact;
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
        $dataProvider = $this->reviews->getAllByFun($fun->id);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'fun' => $fun,
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