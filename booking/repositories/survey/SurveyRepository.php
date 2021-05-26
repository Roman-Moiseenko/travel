<?php


namespace booking\repositories\survey;


use booking\entities\survey\Survey;

class SurveyRepository
{
    public function get($id): Survey
    {
        if (!$result = Survey::findOne($id)) {
            throw new \DomainException('Опрос не найден');
        }
        return $result;
    }

    public function save(Survey $survey)
    {
        if (!$survey->save()) {
            throw new \DomainException('Опрос не сохранен');
        }
    }

    public function remove(Survey $survey)
    {
        if (!$survey->delete()) {
            throw new \DomainException('Ошибка удаления опроса');
        }
    }
}