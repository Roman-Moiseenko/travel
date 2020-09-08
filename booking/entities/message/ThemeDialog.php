<?php


namespace booking\entities\message;


use booking\entities\Lang;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Class ThemeDialog
 * @package booking\entities\message
 * @property integer $id
 * @property string $caption
 * @property integer $type_dialog
 */

class ThemeDialog extends ActiveRecord
{

    public static function create($caption, $typeDialog): self
    {
        $theme = new static();
        $theme->caption = $caption;
        $theme->type_dialog = $typeDialog;
        return $theme;
    }

    public static function tableName()
    {
        return '{{%booking_dialog_themes}}';
    }

    public static function getList($typeDialog): array
    {
        $list = ThemeDialog::find()->andWhere(['type_dialog' => $typeDialog])->all();
        return ArrayHelper::map($list, 'id', function (ThemeDialog $theme) {
            return Lang::t($theme->caption);
        });
    }
}