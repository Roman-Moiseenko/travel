<?php


namespace booking\entities\forum;


use booking\entities\admin\User;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Post
 * @package booking\entities\forum
 * @property integer $id
 * @property integer $category_id
 * @property integer $user_id
 * @property string $caption
 * @property integer $created_at
 * @property integer $update_at
 * @property integer $count
 * @property integer $last_sort
 * @property integer $status
 * @property bool $fix
 * @property Category $category
 * @property Message[] $messages
 * @property Message $lastMessage
 * @property User $user
 */
class Post extends ActiveRecord
{
    const STATUS_LOCK = 5;
    const STATUS_ACTIVE = 10;

    public static function create($category_id, $user_id, $caption): self
    {
        $post = new static();
        $post->category_id = $category_id;
        $post->user_id = $user_id;
        $post->caption = $caption;
        //$post->last_sort = 0;
        $post->count = 0;
        $post->created_at = time();
        $post->status = self::STATUS_ACTIVE;
        return $post;
    }

    public function addMessage(Message $_message): Message
    {
        $messages = $this->messages;
        $_message->sort = ++$this->last_sort;
        $messages[] = $_message;
        $this->messages = $messages;
        $this->update_at = $_message->created_at;
        $this->count = count($messages);
        return $_message;
    }

    public function editMessage($id, $text)
    {
        $messages = $this->messages;
        foreach ($messages as $i => $message) {
            if ($message->isFor($id)) {
                $message->edit($text);
                $this->update_at = $message->updated_at;
                $this->messages = $messages;
                return $message;
            }
        }
        throw new \DomainException('Не найдено сообщение ID = '. $id . ' Поста '. $this->caption);
    }

    public function removeMessage($id)
    {
        $messages = $this->messages;
        foreach ($messages as $i => $message) {
            if ($message->isFor($id)) {
                unset($messages[$i]);
                $this->messages = $messages;
                $this->count--;
                return;
            }
        }
        throw new \DomainException('Не найдено сообщение ID = '. $id . ' Поста '. $this->caption);
    }

    public function lock()
    {
        $this->status = self::STATUS_LOCK;
    }

    public function fixed()
    {
        $this->fix = true;
    }

    public function unFixed()
    {
        $this->fix = false;
    }

    public function unLock()
    {
        $this->status = self::STATUS_ACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isFix(): bool
    {
        return $this->fix;
    }

    public static function tableName()
    {
        return '{{%forum_posts}}';
    }
    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'messages'
                ],
            ],
        ];
    }
    public function getLastMessage(): ActiveQuery
    {
        return Message::find()
            ->andWhere(['post_id' => $this->id])
            ->andWhere([
                'created_at' => Message::find()->andWhere(['post_id' => $this->id])->max('created_at')
            ]);
        //return $this->hasOne(Message::class, ['sort' => 'last_sort', 'post_id' => 'id']);
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getMessages(): ActiveQuery
    {
        return $this->hasMany(Message::class, ['post_id' => 'id']);
    }

    public function isAuthor($id, int $user_id): bool
    {
        $messages = $this->messages;
        foreach ($messages as $i => $message) {
            if ($message->isFor($id)) {
                if ($message->user_id == $user_id) {
                    return true;
                } else {
                    return false;
                }
            }
        }
        throw new \DomainException('Не найдено сообщение ID = '. $id . ' Поста '. $this->caption);
    }

}