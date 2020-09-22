<?php


namespace booking\helpers;


use booking\entities\admin\UserLegal;
use yii\helpers\ArrayHelper;

class AdminUserHelper
{
    public static function listLegals(): array
    {
        $id = \Yii::$app->user->id;
        return ArrayHelper::map(UserLegal::find()->andWhere(['user_id' => $id])->asArray()->all(),
            'id',
            function (array $legal) {
            return $legal['name'];
            });
    }
}