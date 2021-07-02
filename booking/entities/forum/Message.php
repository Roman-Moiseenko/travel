<?php


namespace booking\entities\forum;


use booking\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Message
 * @package booking\entities\forum
 * @property integer $id
 * @property integer $post_id
 * @property integer $user_id
 * @property string $text
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $sort
 * @property Post $post
 * @property User $user
 */
class Message extends ActiveRecord
{
    public static function create($user_id, $text): self
    {
        $message = new static();
        //$message->post_id = $post_id;
        $message->user_id = $user_id;
        $message->text = $text;
        $message->created_at = time();
        // $message->sort = $sort;
        return $message;
    }

    public function lastDate(): int
    {
        return $this->updated_at ?? $this->created_at;
    }

    public function edit($text): void
    {
        $this->text = $text;
        $this->updated_at = time();
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public static function tableName()
    {
        return '{{%user_forum_messages}}';
    }

    public function getPost(): ActiveQuery
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function userName($short = false): string
    {
        if ($this->user->personal->fullname->isEmpty()) return 'Неизвестная личность';
        return $short
            ? $this->user->personal->fullname->getShortname()
            : $this->user->personal->fullname->getFullname();
    }

    public function date(): string
    {
        $arr = ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'];
        $month = date('m', $this->created_at);
        return date('d', $this->created_at) . ', ' .
            $arr[(int)date('m', $this->created_at) - 1] . ' ' .
            date('Y H:i', $this->created_at);
    }

    public function caption(): string
    {
        return $this->post->caption;
    }
}