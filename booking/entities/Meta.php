<?php


namespace booking\entities;


class Meta
{
    public $title;
    public $description;
    public $keywords;

    public function __construct($title = null, $description = null, $keywords = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }

}