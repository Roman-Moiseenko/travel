<?php


namespace booking\entities\survey;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Questionnaire
 * @package booking\entities\survey
 * @property integer $id
 * @property integer $created_at
 * @property string $user_cookie
 * @property integer $survey_id
 * @property Answer[] $answers
 */

class Questionnaire extends ActiveRecord
{
    public static function create($user_cookie, $survey_id): self
    {
        $questionnaire = new static();
        $questionnaire->user_cookie = $user_cookie;
        $questionnaire->survey_id = $survey_id;
        $questionnaire->created_at = time();
        return $questionnaire;
    }

    public function addAnswer(Answer $answer)
    {
        $answers = $this->answers;
        $answers[] = $answer;
        $this->answers = $answers;
    }

    public static function tableName()
    {
        return '{{%survey_questionnaire}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'answers',
                ],
            ],
        ];
    }

    public function getAnswers(): ActiveQuery
    {
        return $this->hasMany(Answer::class, ['questionnaire_id' => 'id']);
    }
}