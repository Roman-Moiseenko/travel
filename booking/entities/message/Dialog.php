<?php


namespace booking\entities\message;


use booking\entities\user\User;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Dialog
 * @package booking\entities
 * @property integer $id
 * @property integer $typeDialog
 * @property integer $user_id
 * @property integer $provider_id
 * @property integer $theme_id
 * @property string $optional
 * @property integer $created_at
 * @property integer $status
 * @property Conversation[] $conversations
 * @property ThemeDialog $theme
 * @property User $user
 * @property \booking\entities\admin\user\User $admin
 */

class Dialog extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const CLIENT_PROVIDER = 1;
    const PROVIDER_SUPPORT = 2;
    const CLIENT_SUPPORT = 3;

    public static function create($user_id, $typeDialog, $provider_id, $theme_id, $optional): self
    {
        $dialog = new static();
        $dialog->user_id = $user_id;
        $dialog->theme_id = $theme_id;
        $dialog->typeDialog = $typeDialog;
        $dialog->provider_id = $provider_id;
        $dialog->optional = $optional; //Номер брони и др
        $dialog->status = self::STATUS_ACTIVE;
        $dialog->created_at = time();
        return $dialog;
    }

    public function inactive()
    {
        $this->status = self::STATUS_INACTIVE;
    }

    public function isActive(): bool
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function addConversation($text)
    {
        $conversations = $this->conversations;
        $conversation = Conversation::create($text);
        $conversations[] = $conversation;
        $this->conversations = $conversations;
    }

    public function lastConversation(): int
    {
        $conversations = $this->conversations;
        $last = 0;
        foreach ($conversations as $conversation) {
            if ($conversation->created_at > $last)
                $last = $conversation->created_at;
        }
        return $last;
    }

    public function readConversation()
    {
        $conversations = $this->conversations;
        foreach ($conversations as &$conversation) {
            if ($conversation->author != get_class(\Yii::$app->user->identity) && $conversation->isNew()) {
                $conversation->read();
            }
        }
        $this->conversations = $conversations;
    }

    public function countNewConversation(): int
    {
        $count = 0;
        $conversations = $this->conversations;
        foreach ($conversations as $conversation) {
            if ($conversation->author != get_class(\Yii::$app->user->identity) && $conversation->isNew())
                $count++;
        }
        return $count;
    }

    public function deleteConversation($id)
    {
        $conversations = $this->conversations;
        foreach ($conversations as &$conversation) {
            if ($conversation->isFor($id)) {
                $conversation->deleted();
            }
        }
        $this->conversations = $conversations;
    }

    public function behaviors()
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'conversations',
                ],
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%booking_dialog}}';
    }

    public function getConversations(): ActiveQuery
    {
        return $this->hasMany(Conversation::class, ['dialog_id' => 'id']);
    }

    public function getTheme(): ActiveQuery
    {
        return $this->hasOne(ThemeDialog::class, ['id' => 'theme_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getAdmin(): ActiveQuery
    {
        if ($this->provider_id !== null)
            return $this->hasOne(\booking\entities\admin\user\User::class, ['id' => 'user_id']);
        return null;
    }
}