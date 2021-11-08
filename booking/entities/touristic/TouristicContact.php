<?php


namespace booking\entities\touristic;


use booking\helpers\scr;

class TouristicContact
{
    public $phone;
    public $url;
    public $email;

    public function __construct($phone, $url, $email)
    {
        $this->phone = $phone;
        $this->url = $url;
        $this->email = $email;
    }

    public function getFirstContact(): string
    {
        $next = '';
        if ($this->countContact() > 1) $next = ' ...';
        if (!empty($this->phone)) return '<i class="fas fa-phone-volume"></i>' . $this->phone . $next;
        if (!empty($this->url)) return '<i class="fas fa-globe"></i>' . $this->url . $next;
        if (!empty($this->email)) return '<i class="far fa-envelope"></i>' . $this->email . $next;
        return '-';
    }

    public function countContact(): int
    {
        $n = 0;
        if (!empty($this->phone)) $n++;
        if (!empty($this->url)) $n++;
        if (!empty($this->email)) $n++;
        return $n;
    }
}