<?php


namespace booking\repositories\survey;


use booking\entities\survey\Questionnaire;

class QuestionnaireRepository
{
    public function get($id): Questionnaire
    {
        if (!$result = Questionnaire::findOne($id)) {
            throw new \DomainException('Опрос не найден');
        }
        return $result;
    }

    public function save(Questionnaire $questionnaire)
    {
        if (!$questionnaire->save()) {
            throw new \DomainException('Опрос не сохранен');
        }
    }

    public function remove(Questionnaire $questionnaire)
    {
        if (!$questionnaire->delete()) {
            throw new \DomainException('Ошибка удаления опроса');
        }
    }

    public function getByUser($survey_id, string $user_cookie)
    {
        return Questionnaire::find()->andWhere(['survey_id' => $survey_id])->andWhere(['user_cookie' => $user_cookie])->one();
    }
}