<?php


namespace booking\entities\shops\products;


use booking\entities\admin\Legal;
use booking\entities\booking\BaseReview;
use booking\helpers\BookingHelper;
use yii\db\ActiveQuery;
use yii\helpers\Url;

/**
 * Class ReviewProduct
 * @package booking\entities\shops\products
 * @property integer $product_id
 * @property Product $product
 */
class ReviewProduct extends BaseReview
{

    public static function tableName(): string
    {
        return '{{%shops_product_reviews}}';
    }

    public function getLinks(): array
    {
        return [
            'admin' => Url::to(['product/review/index', 'id' => $this->product_id]),
            'frontend' => Url::to(['/shop/product/' . $this->product_id]),
            'update' => Url::to(['cabinet/review/update-product', 'id' => $this->id]),
            'remove' => Url::to(['cabinet/review/delete-product', 'id' => $this->id]),
        ];
    }

    public function getType(): int
    {
        return BookingHelper::BOOKING_TYPE_PRODUCT;
    }

    public function getName(): string
    {
        return $this->product->getName();
    }

    public function getAdmin(): \booking\entities\admin\User
    {
        return $this->product->shop->user;
    }

    public function getLegal(): Legal
    {
        return $this->product->shop->legal;
    }

    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}