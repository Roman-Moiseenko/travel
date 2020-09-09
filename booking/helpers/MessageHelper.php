<?php


namespace booking\helpers;


use booking\entities\message\Dialog;

class MessageHelper
{
    public static function countNew()
    {
        if (\Yii::$app->user->isGuest) return '';
        $dialogs = Dialog::find()->andWhere(['user_id'=>\Yii::$app->user->id])->all();
        $count = 0;
        foreach ($dialogs as $dialog) {
            $count += $dialog->countNewConversation();
        }
        return $count == 0 ? '' : $count;
    }
}