<?php


namespace booking\services\shops;


use booking\entities\shops\cart\Cart;
use booking\entities\shops\cart\CartItem;
use booking\repositories\shops\ProductRepository;

class CartService
{

    /**
     * @var Cart
     */
    private $cart;
    /**
     * @var ProductRepository
     */
    private $products;

    public function __construct(Cart $cart, ProductRepository $products)
    {
        $this->cart = $cart;
        $this->products = $products;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function add($productId, $quantity): void
    {
        $product = $this->products->get($productId);
        $this->cart->add(new CartItem($product, $quantity));
    }

    public function set($id, $quantity): void
    {
        $this->cart->set($id, $quantity);
    }

    public function sub($productId, $quantity): void
    {
        $product = $this->products->get($productId);
        $this->cart->sub(new CartItem($product, $quantity));
    }

    public function remove($id)
    {
        $this->cart->remove($id);
    }

    public function clear(): void
    {
        $this->cart->clear();
    }
}