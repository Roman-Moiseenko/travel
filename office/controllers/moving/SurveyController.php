<?php


namespace office\controllers\moving;


use booking\entities\Rbac;
use booking\entities\survey\Survey;
use booking\forms\survey\SurveyForm;
use booking\services\survey\SurveyService;
use office\forms\moving\SurveySearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class SurveyController extends Controller
{
    /**
     * @var SurveyService
     */
    private $service;

    public function __construct($id, $module, SurveyService $service, $config = [])
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
        $searchModel = new SurveySearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $form = new SurveyForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $survey = $this->service->create($form);
                return $this->redirect(['moving/survey/view', 'id' => $survey->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $survey = Survey::findOne($id);
        $form = new SurveyForm($survey);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($survey->id, $form);
                return $this->redirect(['moving/survey/view', 'id' => $survey->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('update', [
            'survey' => $survey,
            'model' => $form,
        ]);
    }

    public function actionView($id)
    {
        $survey = Survey::findOne($id);
        return $this->render('view', [
            'survey' => $survey,
        ]);
    }

    public function actionActivate($id)
    {
        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash($e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDraft($id)
    {
        try {
            $this->service->draft($id);
        } catch (\DomainException $e) {
            \Yii::$app->session->setFlash($e->getMessage());
        }
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(['/moving/survey']);
    }
}