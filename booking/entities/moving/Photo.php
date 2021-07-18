<?php


namespace booking\entities\moving;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $item_id
 * @property string $alt
 * @property Item $main
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'moving_items';
    protected $name_id = 'item_id';

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Item::class, ['id' => 'item_id']);
    }

    public static function tableName()
    {
        return '{{%moving_pages_item_photos}}';
    }
}