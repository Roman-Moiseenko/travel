<?php


namespace office\controllers\moving;


use booking\entities\Rbac;
use booking\entities\survey\Question;
use booking\entities\survey\Survey;
use booking\entities\survey\Variant;
use booking\forms\survey\QuestionForm;
use booking\forms\survey\VariantForm;
use booking\services\survey\QuestionService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class QuestionController extends Controller
{
    /**
     * @var QuestionService
     */
    private $service;

    public function __construct($id, $module, QuestionService $service, $config = [])
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

    public function actionIndex($id)
    {
        $survey = Survey::findOne($id);
        return $this->render('index', [
            'survey' => $survey,
        ]);
    }

    public function actionCreate($id)
    {
        $survey = Survey::findOne($id);
        $form = new QuestionForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $question = $this->service->create($survey->id, $form);
                return $this->redirect(['moving/question/index', 'id' => $survey->id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'survey' => $survey,
        ]);
    }

    public function actionUpdate($id)
    {
        $question = Question::findOne($id);
        $form = new QuestionForm($question);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($question->id, $form);
                return $this->redirect(['moving/question/index', 'id' => $question->survey_id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'question' => $question,
            'survey' => $question->survey,
        ]);
    }

    public function actionDelete($id)
    {
        $this->service->remove($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveUp($id)
    {
        $this->service->moveUp($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveDown($id)
    {
        $this->service->moveDown($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionCreateVariant($id)
    {
        $question = Question::findOne($id);
        $form = new VariantForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addVariant($question->id, $form);
                return $this->redirect(['moving/question/index', 'id' => $question->survey_id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('create-variant', [
            'model' => $form,
            'question' => $question,
            'survey' => $question->survey,
        ]);
    }

    public function actionUpdateVariant($id)
    {
        //$question = Question::findOne($id);
        $variant = Variant::findOne($id);
        $form = new VariantForm($variant);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->editVariant($id, $form);
                return $this->redirect(['moving/question/index', 'id' => $variant->question->survey_id]);
            } catch (\DomainException $e) {
                \Yii::$app->session->setFlash($e->getMessage());
            }
        }
        return $this->render('update-variant', [
            'model' => $form,
            'question' => $variant->question,
            'survey' => $variant->question->survey,
        ]);
    }

    public function actionMoveUpVariant($id)
    {
        $this->service->moveUpVariant($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionMoveDownVariant($id)
    {
        $this->service->moveDownVariant($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }

    public function actionDeleteVariant($id)
    {
        $this->service->removeVariant($id);
        return $this->redirect(\Yii::$app->request->referrer);
    }
}