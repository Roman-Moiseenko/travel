<?php


namespace booking\forms\booking;


use booking\entities\booking\trips\Video;
use yii\base\Model;

class VideosForm extends Model
{
    public $caption;
    public $caption_en;
    public $url;
    public $type_hosting;

    public function __construct(Video $video = null, $config = [])
    {
        if ($video) {
            $this->caption = $video->caption;
            $this->caption_en = $video->caption_en;
            $this->url = $video->url;
            $this->type_hosting = $video->type_hosting;
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['url', 'caption', 'caption_en'], 'string'],
            [['type_hosting'], 'integer'],
            [['url', 'caption', 'type_hosting'], 'required', 'message' => 'Обязательное поле'],
        ];

    }
}