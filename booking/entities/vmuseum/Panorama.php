<?php


namespace booking\entities\vmuseum;


use booking\entities\booking\BasePhoto;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Panorama
 * @package booking\entities\vmuseum
 * @property integer $id
 * @property integer $sort
 * @property integer $hall_id
 */
class Panorama extends BasePhoto
{
    public static function tableName()
    {
        return '{{%vmuseum_hall_panorama}}';
    }

    public function getMain(): ActiveQuery
    {
        // TODO: Implement getMain() method.
    }
}