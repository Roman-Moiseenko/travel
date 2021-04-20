<?php


namespace booking\entities\shops\cart\cost;


class Cost
{
    private $value;
    private $discounts = [];

    public function __construct(float $value, array $discounts = [])
    {
        $this->value = $value;
        $this->discounts = $discounts;
    }

    public function withDiscount(Discount $discount): self
    {
        return new static($this->value, array_merge($this->discounts, [$discount]));
    }

    public function getOrigin(): float
    {
        return $this->value;
    }

    public function getTotal(): float
    {
        $val = $this->value;
        return $val - array_sum(array_map(function (Discount $discount) use($val) {
                return $val * ($discount->getValue() / 100); // процентная скидка
            }, $this->discounts));
    }

    /**
     * @return Discount[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    public function getPercent(): int
    {
        if (count($this->discounts) == 0) return 0;
        return array_sum(array_map(function (Discount $discount) {return $discount->getValue();}, $this->discounts));
    }
}