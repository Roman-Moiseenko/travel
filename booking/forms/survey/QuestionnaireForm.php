<?php


namespace booking\forms\survey;


use booking\entities\survey\Survey;
use yii\base\Model;

class QuestionnaireForm extends Model
{
    public $survey_id;
    public $questions = [];

    public function __construct(Survey $survey, $config = [])
    {
        $this->survey_id = $survey->id;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
           // ['user', 'string'],
            ['survey_id', 'integer'],
            ['questions', 'each', 'rule' => ['integer']],
        ];
    }

}