<?php


namespace booking\entities\survey;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Question
 * @package booking\entities\survey
 * @property integer $id
 * @property integer $survey_id
 * @property string $question
 * @property Variant[] $variants
 * @property Survey $survey
 * @property int $sort
 */
class Question extends ActiveRecord
{
    public static function create($survey_id, $question): self
    {
        $questionClass = new static();
        $questionClass->survey_id = $survey_id;
        $questionClass->question = $question;
        return $questionClass;
    }

    public function edit($question): void
    {
        $this->question = $question;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function addVariant(Variant $variant): void
    {
        $variants = $this->variants;
        $variants[] = $variant;
        $this->variants = $variants;
    }

    public function editVariant($id, Variant $variant_edit): void
    {
        $variants = $this->variants;
        foreach ($variants as &$variant) {
            if ($variant->isFor($id)) {
                $variant->copy($variant_edit);
                $this->variants = $variants;
                return;
            }
        }
        throw new \DomainException('Вариант ответа не найден ', $id);
    }

    public function removeVariant($id): void
    {
        $variants = $this->variants;
        foreach ($variants as $i => $variant) {
            if ($variant->isFor($id)) {
                unset($variants[$i]);
                $this->variants = $variants;
                return;
            }
        }
        throw new \DomainException('Вариант ответа не найден ', $id);
    }

    public function removeVariants(): void
    {
        $this->variants = [];
    }

    public static function tableName()
    {
        return '{{%survey_question}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'variants',
                ],
            ],
        ];
    }

    public function getVariants(): ActiveQuery
    {
        return $this->hasMany(Variant::class, ['question_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    public function getSurvey(): ActiveQuery
    {
        return $this->hasOne(Survey::class, ['id' => 'survey_id']);
    }
}