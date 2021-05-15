<?php


namespace booking\entities\moving;


use yii\db\ActiveRecord;

/**
 * Class FAQ
 * @package booking\entities\moving
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $category_id
 * @property string $message
 * @property boolean $complete
 *
 */
class FAQ extends ActiveRecord
{
    public static function create($category_id, $message): self
    {
        $faq = new static();
        $faq->category_id = $category_id;
        $faq->message = $message;
        $faq->created_at = time();
        $faq->complete = false;
        return $faq;
    }

    public function edit ($message): void
    {
        $this->message = $message;
    }

    public function completed(): void
    {
        $this->complete = true;
        $this->updated_at = time();
    }

    public function isNew(): bool
    {
        return !$this->complete;
    }

    public function isCompleted(): bool
    {
        return $this->complete;
    }

    public static function tableName()
    {
        return '{{%moving_faq}}';
    }
}