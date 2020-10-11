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
    const PETITION_REVIEW = 1;
    const PETITION_PROVIDER = 2;
    const ACTIVATED = 3;

    public static function create($caption, $typeDialog): self
    {
        $theme = new static();
        $theme->caption = $caption;
        $theme->type_dialog = $typeDialog;
        return $theme;
    }

    public function edit($caption): void
    {
        $this->caption = $caption;
    }

    public static function tableName()
    {
        return '{{%booking_dialog_themes}}';
    }

}