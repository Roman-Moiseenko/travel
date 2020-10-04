<?php


namespace booking\entities\user;


class FullName
{
    public $surname;
    public $firstname;
    public $secondname;
    public function __construct($surname = '', $firstname = '', $secondname = '')
    {
        $this->surname = $surname;
        $this->firstname = $firstname;
        $this->secondname = $secondname;
    }

    public function getFullname(): string
    {
        return  $this->surname . ' ' . $this->firstname . (!empty($this->secondname) ? ' ' . $this->secondname : '') ;
    }

    public function getShortname(): string
    {
        return  $this->surname . ' ' . mb_substr($this->firstname, 0, 1) . '.' . (!empty($this->secondname) ? '' . mb_substr($this->secondname, 0, 1) . '.' : '') ;
    }

    public function isEmpty(): bool
    {
        return empty($this->surname);
    }
}