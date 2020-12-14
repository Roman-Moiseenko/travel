<?php


namespace booking\entities\admin;


use yii\db\ActiveRecord;

/**
 * Class ForumRead
 * @package booking\entities\admin
 * @property integer $id
 * @property integer $user_id
 * @property integer $post_id
 * @property integer $last_at

 */
class ForumRead extends ActiveRecord
{
    public static function create($post_id): self
    {
        $read = new static();
        $read->post_id = $post_id;
        $read->last_at = time();
    }

    public function edit()
    {
        $this->last_at = time();
    }

    public function isFor($id): bool
    {
        return $this->id === $id;
    }

    public static function tableName()
    {
        return '{{%admin_user_forum_read}}';
    }
}