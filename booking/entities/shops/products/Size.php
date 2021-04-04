<?php


namespace booking\entities\shops\products;


class Size
{
    public $width;
    public $height;
    public $depth;


    public function volume(): int
    {
        return $this->width * $this->height * $this->depth;
    }
}