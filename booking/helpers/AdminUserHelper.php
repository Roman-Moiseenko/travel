<?php


namespace booking\helpers;


use booking\entities\admin\User;
use booking\entities\admin\Legal;
use yii\helpers\ArrayHelper;

class AdminUserHelper
{
    public static function listLegals(): array
    {
        $id = \Yii::$app->user->id;
        return ArrayHelper::map(Legal::find()->andWhere(['user_id' => $id])->asArray()->all(),
            'id',
            function (array $legal) {
            return $legal['name'];
            });
    }

    public static function listStatus(): array
    {
        return [
            User::STATUS_LOCK => 'Заблокирован',
            User::STATUS_INACTIVE => 'Новый',
            User::STATUS_ACTIVE => 'Активный',
        ];
    }

    public static function status($status): string
    {
        $list = self::listStatus();
        $value = $list[$status];
        switch ($status) {
            case User::STATUS_LOCK: return '<span class="badge badge-danger">' . $value . '</span>';
            case User::STATUS_INACTIVE: return '<span class="badge badge-secondary">' . $value . '</span>';
            case User::STATUS_ACTIVE: return '<span class="badge badge-success">' . $value . '</span>';
            default:
                throw new \DomainException('Неизвестный статус');
        }
    }
}