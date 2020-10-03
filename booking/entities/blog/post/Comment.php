<?php


namespace booking\entities\blog\post;


use booking\entities\blog\post\queries\PostQuery;
use booking\entities\user\User;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Comment
 * @package shop\entities\blog\post
 * @property int $id
 * @property int $created_at
 * @property int $post_id
 * @property int $user_id
 * @property int $parent_id
 * @property string $text
 * @property bool $active
 *
 * @property Post $post
 */
class Comment extends ActiveRecord
{

    public static function create($userId, $parentId, $text): self
    {
        $comment = new static();
        $comment->user_id = $userId;
        $comment->parent_id = $parentId;
        $comment->text = $text;
        $comment->created_at = time();
        $comment->active = true;
        return $comment;
    }

    /**
     * @param $userName
     * @param $email
     * @param $parentId
     * @param $text
     * @return static
     * @version 0.8
     * Тестовый вариант,  оставлять комментарии не зарегистрированными пользователями
     */
    public static function createGuest($userName, $email, $parentId, $text): self
    {
        $comment = new static();
        $comment->user_id = null;
        $comment->parent_id = $parentId;
        $comment->text = $text;
        $comment->username = $userName;
        $comment->email = $email;
        $comment->created_at = time();
        $comment->active = false;
        return $comment;
    }

    public function edit($parentId, $text): void
    {
        $this->parent_id = $parentId;
        $this->text = $text;
    }

    public function activate(): void
    {
        $this->active = true;
    }

    public function draft(): void
    {
        $this->active = false;
    }

    public function isActive(): bool
    {
        return $this->active == true;
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function isChildOf($id): bool
    {
        return $this->parent_id == $id;
    }

    public function getPost(): PostQuery
    {
        return $this->hasOne(Post::class, ['id' => 'post_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    public static function tableName()
    {
        return '{{%blog_comments}}';
    }
}