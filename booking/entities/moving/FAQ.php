<?php


namespace booking\entities\moving;


use yii\db\ActiveRecord;

/**
 * Class FAQ
 * @package booking\entities\moving
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $category_id
 * @property string $username
 * @property string $email
 * @property string $question
 * @property string $answer
 * @property boolean $complete
 *
 */
class FAQ extends ActiveRecord
{
    public static function create($username, $email, $category_id, $question): self
    {
        $faq = new static();
        $faq->username = $username;
        $faq->email = $email;
        $faq->category_id = $category_id;
        $faq->question = $question;
        $faq->created_at = time();
        $faq->complete = false;
        return $faq;
    }

    public function answer($answer): void
    {
        $this->answer = $answer;
        $this->complete = true;
        $this->updated_at = time();
    }

    public function editAnswer($answer): void
    {
        $this->answer = $answer;

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