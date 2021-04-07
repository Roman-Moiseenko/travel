<?php


namespace booking\entities\shops\products;


use yii\db\ActiveQuery;

/**
 * Class Product
 * @package booking\entities\shops\products
 * @property ReviewProduct[] $reviews
 */
class Product extends BaseProduct
{


    public static function tableName()
    {
        return '{{%shops_product}}';
    }

    public function getPhotos(): ActiveQuery
    {
        return $this->hasMany(Photo::class, ['product_id' => 'id']);
    }

    public function getMainPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }

    public function getReviews(): ActiveQuery
    {
        return $this->hasMany(ReviewProduct::class, ['product_id' => 'id']);

    }
}