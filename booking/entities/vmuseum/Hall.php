<?php


namespace booking\entities\vmuseum;


use yii\db\ActiveRecord;

/**
 * Class Hall
 * @package booking\entities\vmuseum
 * @property integer $id
 * @property integer $sort
 * @property integer $vmuseum_id
 * @property string $name
 * @property string $name_en
 * @property string $description
 * @property string $description_en
 *
 */
class Hall extends ActiveRecord
{
    public static function create($name, $name_en, $description, $description_en): self
    {
        $hall = new static();
        $hall->name = $name;
        $hall->name_en = $name_en;
        $hall->description = $description;
        $hall->description_en = $description_en;

        return $hall;
    }

    public static function tableName()
    {
        return '{{%vmuseum_hall}}';
    }
}