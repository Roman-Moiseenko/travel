<?php


namespace booking\entities\message;


use yii\db\ActiveRecord;

/**
 * Class Conversation
 * @package booking\entities\message
 * @property integer $id
 * @property integer $dialog_id
 * @property string $text
 * @property string $author
 * @property integer $created_at
 * @property integer $status
 */

class Conversation extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_DELETED = 2;
    const STATUS_READ = 3;

    public static function create($text): self
    {
        $conversation = new static();
        $conversation->text = $text;
        $conversation->author = get_class(\Yii::$app->user->identity);
        $conversation->status = self::STATUS_NEW;
        $conversation->created_at = time();
        return $conversation;
    }

    public function deleted()
    {
        $this->status = self::STATUS_DELETED;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function isDeleted(): bool
    {
        return $this->status == self::STATUS_DELETED;
    }

    public function isNew(): bool
    {
        return $this->status == self::STATUS_NEW;
    }

    public function read()
    {
        $this->status = self::STATUS_READ;
    }

    public static function tableName()
    {
        return '{{%booking_dialog_conversation}}';
    }
}