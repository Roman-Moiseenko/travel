<?php


namespace booking\entities\booking;


use yii\db\ActiveRecord;

/**
 * Class BaseVideo
 * @package booking\entities\booking
 * @property integer $id

 * @property string $caption
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $url
 * @property integer $type_hosting
 * @property integer $sort
 */
abstract class BaseVideo extends ActiveRecord
{
    const HOSTING_YOUTUBE = 1;

    public static function create($caption, $url, $type_hosting = self::HOSTING_YOUTUBE): self
    {
        $video = new static();
        $video->caption = $caption;
        $video->url = $url;
        $video->type_hosting = $type_hosting;
        $video->created_at = time();
        return $video;
    }

    public static function list()
    {
        return [
            self::HOSTING_YOUTUBE => 'YouTube',
        ];
    }

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public function edit($caption, $url, $type_hosting = self::HOSTING_YOUTUBE): void
    {
        $this->caption = $caption;
        $this->url = $url;
        $this->type_hosting = $type_hosting;
        $this->updated_at = time();
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }
}