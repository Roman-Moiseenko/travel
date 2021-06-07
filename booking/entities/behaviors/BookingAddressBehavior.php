<?php

namespace booking\entities\behaviors;

use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\helpers\scr;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class BookingAddressBehavior extends Behavior
{
    public $attribute = 'address';
    //public $jsonAttribute = 'meta_json';

    public function events(): array
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'onAfterFind',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'onBeforeSave',
            ActiveRecord::EVENT_BEFORE_INSERT => 'onBeforeSave'
        ];
    }

    public function onAfterFind(Event $event): void
    {
        /** @var ActiveRecord $brand */
        $brand = $event->sender;
        //
        //$meta = Json::decode($brand->getAttribute($this->jsonAttribute));
        $brand->{$this->attribute} = new BookingAddress(
            $brand->getAttribute($this->attribute . '_address'),
            $brand->getAttribute($this->attribute . '_latitude'),
            $brand->getAttribute($this->attribute . '_longitude')
        );

    }

    public function onBeforeSave(Event $event): void
    {
        /** @var ActiveRecord $brand */
        $brand = $event->sender;
        $brand->setAttribute($this->attribute . '_address', $brand->{$this->attribute}->address);
        $brand->setAttribute($this->attribute . '_latitude', $brand->{$this->attribute}->latitude);
        $brand->setAttribute($this->attribute . '_longitude', $brand->{$this->attribute}->longitude);
    }
}