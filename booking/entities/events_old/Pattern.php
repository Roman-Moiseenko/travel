<?php


namespace booking\entities\events;


use yii\db\ActiveRecord;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Pattern
 * @package booking\entities\event
 * @property integer $id
 * @property integer $created_at
 * @property string $title
 * @property string $description
 * @property string $photo
 * @property integer $provider_id
 * @property Provider $provider
 * @mixin ImageUploadBehavior
 */
class Pattern extends ActiveRecord
{

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/event_pattern/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/event_pattern/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/event_pattern/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/event_pattern/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 320, 'height' => 320],
                    'cart_list' => ['width' => 160, 'height' => 160],
                    'forum' => ['width' => 140, 'height' => 140],
                    'profile' => ['width' => 400, 'height' => 400],
                ],
            ],
        ];
    }
}