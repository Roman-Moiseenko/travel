<?php


namespace booking\forms;


use booking\entities\mailing\Mailing;
use yii\base\Model;

class MailingForm extends Model
{

    public $theme;
    public $subject;

    public function __construct(Mailing $mailing = null, $config = [])
    {
        if ($mailing) {
            $this->theme = $mailing->theme;
            $this->subject = $mailing->subject;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['theme', 'subject'], 'required', 'message' => 'Обязательное поле'],
            ['subject', 'string'],
            ['theme', 'integer'],
        ];
    }
}