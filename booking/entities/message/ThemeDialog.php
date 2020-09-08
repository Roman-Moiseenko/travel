<?php


namespace booking\entities\message;


use yii\db\ActiveRecord;

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
        return '{{%booking_dialog_theme}}';
    }
}