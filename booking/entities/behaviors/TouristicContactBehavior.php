<?php

namespace booking\entities\behaviors;

use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\touristic\TouristicContact;
use booking\helpers\scr;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class TouristicContactBehavior extends Behavior
{
    public $attribute = 'contact';

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
        $brand->{$this->attribute} = new TouristicContact(
            $brand->getAttribute($this->attribute . '_phone'),
            $brand->getAttribute($this->attribute . '_url'),
            $brand->getAttribute($this->attribute . '_email')
        );

    }

    public function onBeforeSave(Event $event): void
    {
        /** @var ActiveRecord $brand */
        $brand = $event->sender;
        $brand->setAttribute($this->attribute . '_phone', $brand->{$this->attribute}->phone);
        $brand->setAttribute($this->attribute . '_url', $brand->{$this->attribute}->url);
        $brand->setAttribute($this->attribute . '_email', $brand->{$this->attribute}->email);
    }
}