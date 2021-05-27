<?php


namespace booking\entities\survey;


use yii\db\ActiveRecord;

/**
 * Class Answer
 * @package booking\entities\survey
 * @property integer $id
 * @property integer $questionnaire_id
 * @property integer $question_id
 * @property integer $variant_id
 */
class Answer extends ActiveRecord
{
    public static function create($question_id, $variant_id): self
    {
        $answer = new static();
        $answer->question_id = $question_id;
        $answer->variant_id = $variant_id;
        return $answer;
    }

    public static function tableName()
    {
        return '{{%survey_questionnaire_answer}}';
    }
}