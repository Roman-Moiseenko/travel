<?php

namespace booking\entities\behaviors;

use booking\entities\WorkMode;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class WorkModeBehavior extends Behavior
{
    public $attribute = 'workMode';
    public $jsonAttribute = 'work_mode_json';

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
        $_work = Json::decode($brand->getAttribute($this->jsonAttribute));
        $workMode = [];
        for ($i = 0; $i < 7; $i++) {
            if (isset($_work[$i])) {
                $workMode[$i] = new WorkMode($_work[$i]['day_begin'], $_work[$i]['day_end'], $_work[$i]['break_begin'], $_work[$i]['break_end']);
            } else {
                $workMode[$i] = new WorkMode();
            }
        }
        $brand->{$this->attribute} = $workMode;
    }

    public function onBeforeSave(Event $event): void
    {
        /** @var ActiveRecord $brand */
        $brand = $event->sender;
        $brand->setAttribute($this->jsonAttribute, json_encode($brand->{$this->attribute}));
    }
}