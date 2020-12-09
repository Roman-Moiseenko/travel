<?php


namespace booking\forms\admin;


use booking\entities\admin\NoticeItem;
use yii\base\Model;

class NoticeItemForm extends Model
{
    public $email;
    public $phone;
    private $_formName;

    public function __construct(NoticeItem $noticeItem, $formName = null, $config = [])
    {
        $this->email = $noticeItem->email;
        $this->phone = $noticeItem->phone;
        parent::__construct($config);
        $this->_formName = $formName;
    }

    public function formName()
    {
        return $this->_formName ?? parent::formName();
    }

    public function rules()
    {
        return [
            [['email', 'phone'], 'boolean'],
        ];
    }
}