<?php


namespace booking\entities\foods;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $food_id
 * @property string $alt
 * @property Food $main
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{

    protected $catalog = 'foods';
    protected $name_id = 'food_id';

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Food::class, ['id' => 'food_id']);
    }

    public static function tableName()
    {
        return '{{%foods_photo}}';
    }
}