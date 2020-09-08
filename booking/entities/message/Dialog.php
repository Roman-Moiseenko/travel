<?php


namespace booking\entities\message;


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
 * @property integer $theme
 * @property string $optional
 * @property integer $created_at
 * @property integer $status
 * @property Conversation[] $conversations
 */

class Dialog extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const CLIENT_PROVIDER = 1;
    const PROVIDER_SUPPORT = 2;
    const CLIENT_SUPPORT = 3;

    public static function create($typeDialog, $provider_id, $theme, $optional): self
    {
        $dialog = new static();
        $dialog->theme = $theme;
        $dialog->typeDialog = $typeDialog;
        $dialog->provider_id = $provider_id;
        $dialog->optional = $optional;
        $dialog->status = self::STATUS_ACTIVE;
        $dialog->created_at = time();
        return $dialog;
    }


    public function addConversation($text)
    {
        $conversations = $this->conversations;
        $conversation = Conversation::create($text);
        $conversations[] = $conversation;
        $this->conversations = $conversations;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
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
        return $this->hasMany(Conversation::class, ['dialog_id', 'id']);
    }
}