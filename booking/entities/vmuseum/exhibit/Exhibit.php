<?php


namespace booking\entities\vmuseum\exhibit;


use booking\helpers\StatusHelper;
use yii\db\ActiveRecord;

/**
 * Class Exhibit
 * @package booking\entities\vmuseum
 * @property integer $id
 * @property integer $hall_id
 * @property integer $status
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 * @property integer $photo360 //кол-во фотографий, или null (0), если нет
 */
class Exhibit extends ActiveRecord
{
    public static function create($hall_id, $name, $name_en, $description, $description_en): self
    {
        $exhibit = new static();

        $exhibit->status = StatusHelper::STATUS_INACTIVE;
        return $exhibit;
    }

    public static function tableName()
    {
        return '{{%vmuseum_hall_exhibit}}';
    }
}