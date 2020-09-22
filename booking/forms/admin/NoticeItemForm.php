<?php


namespace booking\forms\admin;


use booking\entities\admin\NoticeItem;
use yii\base\Model;

class NoticeItemForm extends Model
{
    public $email;
    public $phone;
    public function __construct(NoticeItem $noticeItem, $config = [])
    {
        $this->email = $noticeItem->email;
        $this->phone = $noticeItem->phone;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['email', 'phone'], 'boolean'],
        ];
    }
}