<?php


namespace booking\entities\survey;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Variant
 * @package booking\entities\survey
 * @property integer $id
 * @property integer $question_id
 * @property string $text
 * @property Question $question
 * @property int $sort
 */
class Variant extends ActiveRecord
{
    public static function create($text, $sort): self
    {
        $variant = new static();
        $variant->text = $text;
        $variant->sort = $sort;
        return $variant;
    }

    public function edit($text): void
    {
        $this->text = $text;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName()
    {
        return '{{%survey_variant}}';
    }

    public function getQuestion(): ActiveQuery
    {
        return $this->hasOne(Question::class, ['id' => 'question_id']);
    }

    public function copy(Variant $variant_edit)
    {
        $this->text = $variant_edit->text;
    }
}