<?php


namespace frontend\controllers;


use booking\entities\survey\Survey;
use booking\forms\survey\SurveyUserForm;
use booking\helpers\scr;
use yii\helpers\Url;
use yii\web\Controller;

class SurveyController extends Controller
{
    public $layout = 'main_moving';

    public function actionView($id)
    {

        $survey = Survey::findOne($id);
        if (!$survey->isActive()) {
            \Yii::$app->session->setFlash('Опрос заблокирован!');
            return $this->redirect(\Yii::$app->request->referrer);
        }

        //Получаем пользователя из куки ....
        //Проверяем проходил ли он опрос

        //Если да, то показываем результат

        //Если нет, то возможность голосования
        $form = new SurveyUserForm($survey);
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            try {
                //сохраняем
                scr::p($form);
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