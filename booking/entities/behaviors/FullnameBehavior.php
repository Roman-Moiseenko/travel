<?php

namespace booking\entities\behaviors;

use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\helpers\scr;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class FullnameBehavior extends Behavior
{
    public $attribute = 'person';

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
            $brand->getAttribute($this->attribute . '_surname'),
            $brand->getAttribute($this->attribute . '_firstname'),
            $brand->getAttribute($this->attribute . '_secondname')
        );

    }

    public function onBeforeSave(Event $event): void
    {
        /** @var ActiveRecord $brand */
        $brand = $event->sender;
        $brand->setAttribute($this->attribute . '_surname', $brand->{$this->attribute}->surname);
        $brand->setAttribute($this->attribute . '_firstname', $brand->{$this->attribute}->firstname);
        $brand->setAttribute($this->attribute . '_secondname', $brand->{$this->attribute}->secondname);
    }
}