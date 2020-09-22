<?php


namespace booking\helpers;


use booking\entities\admin\User;
use booking\entities\message\Dialog;

class MessageHelper
{
    public static function countNew()
    {
        if (\Yii::$app->user->isGuest) return '';
        if (get_class(\Yii::$app->user->identity) == User::class) {
            $field = 'provider_id';
        }
        if (get_class(\Yii::$app->user->identity) == \booking\entities\user\User::class)
        {
            $field = 'user_id';
        }
        $dialogs = Dialog::find()->andWhere([$field=>\Yii::$app->user->id])->all();
        $count = 0;
        foreach ($dialogs as $dialog) {
            $count += $dialog->countNewConversation();
        }
        return $count == 0 ? '' : $count;
    }
}