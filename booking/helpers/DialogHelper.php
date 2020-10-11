<?php


namespace booking\helpers;


use booking\entities\Lang;
use booking\entities\message\Dialog;
use booking\entities\message\ThemeDialog;
use yii\helpers\ArrayHelper;

class DialogHelper
{
    public static function getList($typeDialog): array
    {
        $list = ThemeDialog::find()->andWhere(['type_dialog' => $typeDialog])->all();
        return ArrayHelper::map($list, 'id', function (ThemeDialog $theme) {
            return Lang::t($theme->caption);
        });
    }

    public static function getTypeList(): array
    {
        return [
            Dialog::CLIENT_PROVIDER => 'Клиент - Провайдер',
            Dialog::PROVIDER_SUPPORT => 'Провайдер - Поддержка',
            Dialog::CLIENT_SUPPORT => 'Клиент - Поддержка',
        ];
    }
}