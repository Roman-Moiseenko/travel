<?php


namespace booking\entities;


use yii\db\ActiveRecord;

/**
 * Class PhotoResize
 * @package booking\entities
 * @property integer $id
 * @property string $file
 */
class PhotoResize extends ActiveRecord
{
    public static function create($file): self
    {
        $photoResize = new static();
        $photoResize->file = $file;
        return $photoResize;
    }

    public static function tableName()
    {
        return '{{services_photo_resize}}';
    }
}