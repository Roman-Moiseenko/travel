<?php


namespace booking\entities\admin;


use booking\helpers\ForumHelper;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Preferences
 * @package booking\entities\admin
 * @property integer $id
 * @property integer $user_id
 * @property string $params_json
 */
class Preferences extends ActiveRecord
{
    public $days_review = 7;
    public $view_cancel = true;
    public $forum_role = ForumHelper::FORUM_USER;

    public static function create($days_review = 7, $view_cancel = true): self
    {
        $preferences = new static();
        $preferences->days_review = $days_review;
        $preferences->view_cancel = $view_cancel;
        return $preferences;
    }

    public function setDaysReview($days): void
    {
        $this->days_review = $days;
    }

    public function setViewCancel($view): void
    {
        $this->view_cancel = $view;
    }

    public function isForumLock(): bool
    {
        return $this->forum_role == ForumHelper::FORUM_LOCK;
    }

    public function isForumUser(): bool
    {
        return $this->forum_role == ForumHelper::FORUM_USER;
    }

    public function isForumUpdate(): bool
    {
        return $this->forum_role == ForumHelper::FORUM_ADMIN || $this->forum_role == ForumHelper::FORUM_MODERATOR;
    }

    public function isForumAdmin(): bool
    {
        return $this->forum_role == ForumHelper::FORUM_ADMIN;
    }

    public static function tableName()
    {
        return '{{%admin_user_preferences}}';
    }

    public function afterFind(): void
    {
        $params = Json::decode($this->getAttribute('params_json'), true);

        $this->days_review = $params['days_review'] ?? 7;
        $this->view_cancel = $params['view_cancel'] ?? true;
        $this->forum_role = $params['forum_role'] ?? ForumHelper::FORUM_USER;

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('params_json', Json::encode([
            'days_review' => $this->days_review,
            'view_cancel' => $this->view_cancel,
            'forum_role' => $this->forum_role,
        ]));

        return parent::beforeSave($insert);
    }
}