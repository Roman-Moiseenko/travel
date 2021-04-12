<?php


namespace booking\entities\blog\map;


use booking\entities\booking\BookingAddress;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Points
 * @package booking\entities\blog\map
 * @property integer $id
 * @property integer $map_id
 * @property string $caption
 * @property string $photo
 * @property string $link
 * @property Maps $map
 * @property string $address [varchar(255)]
 * @property string $latitude [varchar(255)]
 * @property string $longitude [varchar(255)]
 * @mixin ImageUploadBehavior
 */

class Point extends ActiveRecord
{
    /** @var $address BookingAddress */
    public $geo;

    public static function create($caption, $link, BookingAddress $geo, UploadedFile $photo = null): self
    {
        $point = new static();
        $point->caption = $caption;
        $point->link = $link;
        $point->geo = $geo;
        if ($photo) $point->photo = $photo;
        return $point;
    }

    public function edit($caption, $link, BookingAddress $geo, UploadedFile $photo = null): void
    {
        $this->caption = $caption;
        $this->link = $link;
        $this->geo = $geo;
        if ($photo) $this->photo = $photo;
    }


    public function equal(Point $point): bool
    {
        return $this->caption == $point->caption || $this->link == $point->link;
    }

    public function isFor($id): bool
    {
        return $this->id = $id;
    }

    public static function tableName()
    {
        return '{{%blog_maps_point}}';
    }

    public function afterFind(): void
    {
        $this->geo = new BookingAddress(
            $this->getAttribute('address'),
            $this->getAttribute('latitude'),
            $this->getAttribute('longitude'),
        );

        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('address', $this->geo->address);
        $this->setAttribute('latitude', $this->geo->latitude);
        $this->setAttribute('longitude', $this->geo->longitude);

        return parent::beforeSave($insert);
    }
    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/maps/[[attribute_map_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/maps/[[attribute_map_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/maps/[[attribute_map_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/maps/[[attribute_map_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'map' => ['width' => 195, 'height' => 150],
                ],
            ],
        ];
    }

    public function getMap(): ActiveQuery
    {
        return $this->hasOne(Maps::class, ['id' => 'map_id']);
    }

}