<?php


namespace booking\helpers;


use yii\helpers\ArrayHelper;

class OfficeUserHelper
{
    public static function rolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public static function roles($id): array
    {
        return ArrayHelper::getColumn(\Yii::$app->authManager->getRolesByUser($id), 'description');
    }
}