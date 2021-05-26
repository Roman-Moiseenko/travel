<?php


namespace booking\forms\survey;


use booking\entities\survey\Survey;
use yii\base\Model;

class SurveyUserForm extends Model
{
    public $survey_id;
    public $user;

    public $questions = [];

    public function __construct(Survey $survey, $config = [])
    {
        $this->survey_id = $survey->id;
        $this->user = '';
        /*foreach ($survey->questions as $question) {
            $this->questions[$question->id] = 0;
        }*/
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['user', 'string'],
            ['id', 'integer'],
            ['questions', 'each', 'rule' => ['integer']],
        ];
    }

}