<?php


namespace booking\entities\shops\cart\cost;


class Discount
{

    /**
     * @var float
     */
    private $value;
    /**
     * @var string
     */
    private $name;


    public function __construct(float $value, string $name)
    {
        $this->value = $value;
        $this->name = $name;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getString(): string
    {
        return $this->value . ' %';
    }
}