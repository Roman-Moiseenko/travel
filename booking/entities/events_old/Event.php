<?php


namespace booking\entities\events;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Event
 * @package booking\entities\event
 * @property integer $id
 * @property integer $created_at
 * @property string $title
 * @property string $description
 * @property integer $event_at //Дата события, после которого сообщение исчезает
 * @property string $photo
 * @property integer $provider_id
 * @property Provider $provider
 */
class Event extends ActiveRecord
{
    public static function create($title, $description, $event_at): self
    {
        $event = new static();
        $event->title = $title;
        $event->description = $description;
        $event->event_at = $event_at;
        $event->created_at = time();
        return $event;
    }


    public function setProvider($id): void
    {
        $this->provider_id = $id;
    }

    public static function tableName()
    {
        return '{{%event}}';
    }

    public function getProvider(): ActiveQuery
    {
        return $this->hasOne(Provider::class, ['id' => 'provider_id']);
    }
}