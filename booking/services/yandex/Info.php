<?php


namespace booking\services\yandex;


class Info
{
    public $name;
    public $company;
    public $url;

    public function __construct($name, $company, $url)
    {
        $this->name = $name;
        $this->company = $company;
        $this->url = $url;
    }
}