<?php


namespace booking\entities\realtor;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $landowner_id
 * @property string $alt
 * @property Landowner $main
 * @mixin ImageUploadBehavior
 */
class Photo extends BasePhoto
{
    protected $catalog = 'realtor_landowners';
    protected $name_id = 'landowner_id';

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Landowner::class, ['id' => 'landowner_id']);
    }

    public static function tableName()
    {
        return '{{%realtor_landowners_photos}}';
    }
}