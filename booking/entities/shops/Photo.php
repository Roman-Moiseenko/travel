<?php


namespace booking\entities\shops;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $shop_id
 * @property string $alt
 * @property Shop $main
 * @mixin ImageUploadBehavior
 */

class Photo extends BasePhoto
{
    protected $catalog = 'shops';
    protected $name_id = 'shop_id';

    public static function tableName()
    {
        return '{{%shops_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Shop::class, ['id' => 'shop_id']);
    }

}