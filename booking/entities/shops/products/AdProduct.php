<?php


namespace booking\entities\shops\products;

use booking\entities\shops\products\queries\AdProductQuery;
use yii\db\ActiveQuery;

class AdProduct extends BaseProduct
{


    public static function tableName()
    {
        return '{{%shops_ad_product}}';
    }

    public function getPhotos(): ActiveQuery
    {
        // TODO: Implement getPhotos() method.
    }

    public function getMainPhoto(): ActiveQuery
    {
        // TODO: Implement getMainPhoto() method.
    }

    public function getReviews(): ActiveQuery
    {
        // TODO: Implement getReviews() method.
    }

    public static function find(): AdProductQuery
    {
        return new AdProductQuery(static::class);
    }

    public function getMaterialAssign(): ActiveQuery
    {
        // TODO: Implement getMaterialAssign() method.
    }
}