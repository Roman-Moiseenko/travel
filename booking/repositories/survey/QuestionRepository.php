<?php


namespace booking\repositories\survey;


use booking\entities\survey\Question;
use booking\entities\survey\Variant;
use Mpdf\Tag\Q;

class QuestionRepository
{
    public function get($id): Question
    {
        if (!$result = Question::findOne($id)) {
            throw new \DomainException('Вопрос не найден');
        }
        return $result;
    }

    public function save(Question $question)
    {
        if (!$question->save()) {
            throw new \DomainException('Вопрос не сохранен');
        }
    }

    public function remove(Question $question)
    {
        if (!$question->delete()) {
            throw new \DomainException('Ошибка удаления вопроса');
        }
    }

    public function getBySurvey(int $survey_id)
    {
        return Question::find()->andWhere(['survey_id' => $survey_id])->orderBy(['sort' => SORT_ASC])->all();
    }

    public function getByVariant($id)
    {
        $variant = Variant::findOne($id);
        if (!$result = Question::findOne($variant->question_id)) {
            throw new \DomainException('Вопрос не найден');
        }
        return $result;
    }

    public function getMaxSort($survey_id)
    {
        return Question::find()->andWhere(['survey_id' => $survey_id])->max('sort');
    }
}