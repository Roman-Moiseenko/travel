<?php


namespace booking\entities\survey;

use booking\entities\behaviors\MetaBehavior;
use booking\entities\Meta;
use booking\entities\queries\ObjectActiveQuery;
use booking\helpers\StatusHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Survey
 * @package booking\entities\survey
 * @property integer $id
 * @property string $caption
 * @property integer $created_at
 * @property string $description
 * @property string $meta_json
 * "@property integer $status
 * @property Question[] $questions
 */
class Survey extends ActiveRecord
{
    /** @var $meta Meta */
    public $meta;


    public static function create($caption): self
    {
        $survey = new static();
        $survey->caption = $caption;
        $survey->status = StatusHelper::STATUS_INACTIVE;
        return $survey;
    }

    public function edit($caption): void
    {
        $this->caption = $caption;
    }

    public function isActive(): bool
    {
        return $this->status == StatusHelper::STATUS_ACTIVE;
    }

    public function activate(): void
    {
        $this->status = StatusHelper::STATUS_ACTIVE;
    }

    public function draft(): void
    {
        $this->status = StatusHelper::STATUS_INACTIVE;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function behaviors()
    {
        return [
            MetaBehavior::class,
        ];
    }

    public static function tableName()
    {
        return '{{%survey}}';
    }

    public function getQuestions(): ActiveQuery
    {
        return $this->hasMany(Question::class, ['survey_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    public static function find(): ObjectActiveQuery
    {
        return new ObjectActiveQuery(static::class);
    }
}