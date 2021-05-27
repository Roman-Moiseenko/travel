<?php


namespace frontend\controllers;


use booking\entities\survey\Questionnaire;
use booking\entities\survey\Survey;
use booking\forms\survey\QuestionnaireForm;
use booking\helpers\scr;
use booking\services\survey\QuestionnaireService;
use yii\helpers\Url;
use yii\web\Controller;

class SurveyController extends Controller
{
    public $layout = 'main_moving';
    /**
     * @var QuestionnaireService
     */
    private $service;

    public function __construct($id, $module, QuestionnaireService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionView($id)
    {
        $survey = Survey::findOne($id);
        if (!$survey->isActive()) {
            \Yii::$app->session->setFlash('Опрос заблокирован!');
            return $this->redirect(\Yii::$app->request->referrer);
        }

        if ($questionnaire = $this->service->checkSurvey($survey->id)) {
            $array = [];
            foreach ($survey->questions as $question) {
                foreach ($question->variants as $variant) {
                    $array[$question->id][$variant->id] = Questionnaire::find()->alias('q')
                        ->andWhere(['q.survey_id' => $survey->id])
                        ->joinWith('answers a')
                        ->andWhere(['a.question_id' => $question->id])
                        ->andWhere(['a.variant_id' => $variant->id])->count();
                    }
            }

            return $this->render('view', [
                'array_questionnaire' => $array,
                'questionnaire' => $questionnaire,
            ]);
        } else { //Если нет, то возможность голосования
            $form = new QuestionnaireForm($survey);
            if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
                try {
                    //сохраняем
                    $this->service->create($form);
                    return $this->redirect(Url::to(['/survey/view', 'id' => $id]));
                } catch (\DomainException $e) {
                    \Yii::$app->session->setFlash($e->getMessage());
                }
            }
            return $this->render('new', [
                'survey' => $survey,
                'model' => $form,
            ]);
        }
    }
}