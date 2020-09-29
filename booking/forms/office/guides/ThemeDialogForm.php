<?php


namespace booking\forms\office\guides;


use booking\entities\message\ThemeDialog;
use yii\base\Model;

class ThemeDialogForm extends Model
{
    public $caption;
    public $type_dialog;

    public function __construct(ThemeDialog $theme = null, $config = [])
    {
        if ($theme != null) {
            $this->caption = $theme->caption;
            $this->type_dialog = $theme->type_dialog;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['caption', 'string'],
            ['type_dialog', 'integer'],
            [['caption', 'type_dialog'], 'required'],
        ];
    }
}