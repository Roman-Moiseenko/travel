<?php


namespace booking\entities\admin;


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