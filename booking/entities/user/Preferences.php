<?php


namespace booking\entities\user;


use booking\entities\Currency;
use booking\helpers\CurrencyHelper;
use booking\helpers\UserForumHelper;
use yii\db\ActiveRecord;

/**
 * Class Preferences
 * @package booking\entities\user
 * @property integer $id
 * @property integer $user_id
 * @property string $lang
 * @property string $currency
 * @property integer $smocking
 * @property integer $stars
 * @property boolean $disabled
 * @property boolean $newsletter
 * @property boolean $notice_dialog
 * @property integer $forum_role
 */

class Preferences extends ActiveRecord
{
    public static function create($lang = 'ru', $currency = CurrencyHelper::RUB)
    {
        $preferences = new static();
        $preferences->lang = $lang;
        $preferences->currency = $currency;

        $preferences->smocking = false;
        $preferences->stars = 0;
        $preferences->disabled = false;
        $preferences->newsletter = false;
        $preferences->notice_dialog = true;
        $preferences->forum_role = UserForumHelper::FORUM_USER;
        return $preferences;
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }
    public function isForumLock(): bool
    {
        return $this->forum_role == UserForumHelper::FORUM_LOCK;
    }

    public function isForumUser(): bool
    {
        return $this->forum_role == UserForumHelper::FORUM_USER;
    }

    public function isForumUpdate(): bool
    {
        return $this->forum_role == UserForumHelper::FORUM_ADMIN || $this->forum_role == UserForumHelper::FORUM_MODERATOR;
    }

    public function isForumAdmin(): bool
    {
        return $this->forum_role == UserForumHelper::FORUM_ADMIN;
    }

    public static function tableName()
    {
        return '{{%user_preferences}}';
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

}