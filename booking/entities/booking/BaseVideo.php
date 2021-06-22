<?php


namespace booking\entities\booking;


use booking\entities\Lang;
use yii\db\ActiveRecord;

/**
 * Class BaseVideo
 * @package booking\entities\booking
 * @property integer $id

 * @property string $caption
 * @property string $caption_en
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $url
 * @property integer $type_hosting
 * @property integer $sort
 */
abstract class BaseVideo extends ActiveRecord
{
    const HOSTING_YOUTUBE = 1;

    public static function create($caption, $url, $caption_en, $type_hosting): self
    {
        $video = new static();
        $video->caption = $caption;
        $video->caption_en = $caption_en;
        $video->url = $url;
        $video->type_hosting = $type_hosting ?? self::HOSTING_YOUTUBE;
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

    public function edit($caption, $url, $caption_en, $type_hosting): void
    {
        $this->caption = $caption;
        $this->caption_en = $caption_en;
        $this->url = $url;
        $this->type_hosting = $type_hosting ?? self::HOSTING_YOUTUBE;
        $this->updated_at = time();
    }

    public function getCaption(): string
    {
        return Lang::current() == Lang::DEFAULT ? $this->caption : $this->caption_en;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }
}