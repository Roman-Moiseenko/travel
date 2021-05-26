<?php


namespace booking\entities\survey;

use yii\db\ActiveRecord;

/**
 * Class Questionnaire
 * @package booking\entities\survey
 * @property integer $id
 * @property integer $created_at
 * @property integer $user_id
 * @property string $user_cookie
 * @property integer $question_id
 * @property integer $variant_id
 */
class Questionnaire extends ActiveRecord
{
    public static function create($user_id, $user_cookie, $question_id, $variant_id): self
    {
        $questionnaire = new static();
        $questionnaire->user_id = $user_id;
        $questionnaire->user_cookie = $user_cookie;
        $questionnaire->question_id = $question_id;
        $questionnaire->variant_id = $variant_id;
        return $questionnaire;
    }
    public static function tableName()
    {
        return '{{%survey_questionnaire}}';
    }
}