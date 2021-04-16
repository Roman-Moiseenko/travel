<?php


namespace booking\entities\shops;


use booking\entities\booking\BasePhoto;
use booking\entities\booking\funs\WorkMode;
use yii\db\ActiveQuery;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property string $file
 * @property integer $sort
 * @property integer $shop_id
 * @property string $alt
 * @property string $work_mode_json
 * @property Shop $main
 * @mixin ImageUploadBehavior
 */

class AdPhoto extends BasePhoto
{
    /** @var WorkMode[] $workModes */
    public $workModes = [];

    protected $catalog = 'shops';
    protected $name_id = 'shop_id';

    public static function tableName()
    {
        return '{{%shops_ad_photos}}';
    }

    public function getMain(): ActiveQuery
    {
        return $this->hasOne(Shop::class, ['id' => 'shop_id']);
    }

}