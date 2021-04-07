<?php


namespace booking\forms\shops;


use booking\entities\shops\products\Product;
use booking\entities\shops\products\Size;
use booking\forms\CompositeForm;

class ProductForm extends CompositeForm
{
    public $name;
    public $name_en;
    public $description;
    public $description_en;
    public $weight;
    /** @var Size $size */
    public $size;
    public $article;
    public $collection;
    public $color;
    public $manufactured_id;
    public $category_id;
    public $cost;
    public $discount;

    public function __construct(Product $product = null, $config = [])
    {
        if ($product) {
            $this->name = $product->name;
            $this->name_en = $product->name_en;
            $this->description = $product->description_en;
            $this->weight = $product->weight;
            $this->size = clone $product->size;
            $this->article = $product->article;
            $this->collection = $product->collection;
            $this->color = $product->color;
            $this->manufactured_id = $product->manufactured_id;
            $this->category_id = $product->category_id;
            $this->cost = $product->cost;
            $this->discount = $product->discount;

            //TODO MaterialAssign
        }
        parent::__construct($config);
    }

    protected function internalForms(): array
    {
        // TODO: Implement internalForms() method.
    }
}