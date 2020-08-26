<?php


namespace booking\entities\admin\user;


class NoticeItem
{
    public $phone;
    public $email;

    public function __construct($email = true, $phone = false)
    {
        $this->email = $email;
        $this->phone = $phone;
    }

}