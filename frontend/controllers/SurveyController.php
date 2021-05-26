<?php


namespace frontend\controllers;


use booking\entities\survey\Survey;
use booking\forms\survey\SurveyUserForm;
use yii\web\Controller;

class SurveyController extends Controller
{
    public $layout = 'main_moving';

    public function actionView($id)
    {
        $survey = Survey::findOne($id);
        $form = new SurveyUserForm($survey);
        if ($survey->isActive()) {
            return $this->render('view', [
                'survey' => $survey,
                'model' => $form,
            ]);
        }
    }
}