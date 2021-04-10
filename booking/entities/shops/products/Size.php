<?php


namespace booking\entities\shops\products;


class Size
{
    public $width;
    public $height;
    public $depth;

    public static function create($width, $height, $depth): self
    {
        $size = new static();
        $size->width = $width;
        $size->height = $height;
        $size->depth = $depth;
        return $size;
    }

    public function volume(): int
    {
        return $this->width * $this->height * $this->depth;
    }
}