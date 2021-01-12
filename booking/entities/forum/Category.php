<?php


namespace booking\entities\forum;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Category
 * @package booking\entities\forum
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $count
 * @property integer $last_id
 * @property integer $status
 * @property integer $sort
 * @property Post[] $posts
 * @property Message $lastMessage
 */
class Category extends ActiveRecord
{
    const STATUS_LOCK = 5;
    const STATUS_ACTIVE = 10;

    public static function create($name, $description, $sort): self
    {
        $category = new static();
        $category->name = $name;
        $category->description = $description;
        $category->created_at = time();
        $category->sort = $sort;
        $category->count = 0;
        $category->status = self::STATUS_ACTIVE;
        return $category;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function edit($name, $description): void
    {
        $this->name = $name;
        $this->description = $description;
    }

    public function updated(Message $message): void
    {
        $this->updated_at = $message->created_at;
        $this->count++;
        $this->last_id = $message->id;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
    }

    public function subUpdated($last_id)
    {
        $this->count--;
        $this->last_id = $last_id;
    }

    public function editUpdated(Message $message)
    {
        $this->updated_at = $message->updated_at;
    }

    public static function tableName()
    {
        return '{{%forum_categories}}';
    }

    public function getPosts(): ActiveQuery
    {
        return $this->hasMany(Post::class, ['category_id' => 'id']);
    }

    public function countPost(): int
    {
        return count($this->posts);
    }

    public function getLastMessage()
    {
        return Message::findOne($this->last_id);
    }
}