<?php


namespace booking\entities\survey;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Answer
 * @package booking\entities\survey
 * @property integer $id
 * @property integer $questionnaire_id
 * @property integer $question_id
 * @property integer $variant_id
 * @property Question $question
 * @property Variant $variant
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

    public function getQuestion(): ActiveQuery
    {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }

    public function getVariant(): ActiveQuery
    {
        return $this->hasOne(Variant::class, ['id' => 'variant_id']);
    }
}