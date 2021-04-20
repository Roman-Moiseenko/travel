<?php


namespace booking\entities\user;

use booking\entities\booking\WishlistItemInterface;
use booking\entities\shops\products\Product;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * @property integer $user_id
 * @property integer $product_id
 * @property Product $product
 */
class WishlistProduct extends ActiveRecord implements WishlistItemInterface
{

    public static function create($product_id): self
    {
        $wishlist = new static();
        $wishlist->product_id = $product_id;
        return $wishlist;
    }

    public function isFor($product_id): bool
    {
        return $this->product_id == $product_id;
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public static function tableName()
    {
        return '{{%user_wishlist_products}}';
    }

    /** ===> WishlistItemInterface */

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function getLink(): string
    {
        return Url::to(['/shop/product/' . $this->product_id]);
    }

    public function getPhoto(): string
    {
        return $this->product->mainPhoto->getThumbFileUrl('file', 'cabinet_list');
    }

    public function getType(): string
    {
        return BookingHelper::BOOKING_TYPE_SHOP;
    }

    public function getId(): int
    {
        return $this->product_id;
    }

    public function getRemoveLink(): string
    {
        return Url::to(['cabinet/wishlist/del-product', 'id' => $this->product_id]);
    }
}