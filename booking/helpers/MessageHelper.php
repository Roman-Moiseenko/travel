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
        $dialogs = Dialog::find()->andWhere([$field =>\Yii::$app->user->id])->all();
        $count = 0;
        foreach ($dialogs as $dialog) {
            $count += $dialog->countNewConversation();
        }
        return $count == 0 ? '' : $count;
    }

    public static function countNewSupportByType($type)
    {
        if (\Yii::$app->user->isGuest) return '';
        $dialogs = Dialog::find()->andWhere(['typeDialog' => $type])->all();
        $count = 0;
        foreach ($dialogs as $dialog) {
            $count += $dialog->countNewConversation();
        }
        return $count == 0 ? '' : $count;
    }

    public static function countNewSupport()
    {
        $provider = self::countNewSupportByType(Dialog::PROVIDER_SUPPORT);
        $client = self::countNewSupportByType(Dialog::CLIENT_SUPPORT);
        $count = ($provider == '' ? 0 : $provider) + ($client == '' ? 0 : $client);
        return  $count == 0 ? '' : $count;
    }


}