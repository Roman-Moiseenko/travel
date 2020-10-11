<?php


namespace frontend\widgets;


use yii\base\Widget;

class SuggestWidget extends Widget
{
    public function run()
    {
        //TODO Рекомендуем посетить сущность Suggest - {{%booking_suggest}}
        // id, object_id, object_class, status, created_at, finished_at, count, remains
        // $suggests = $this->suggests->getForWidget($count_view = 4): array
        // $this->>service->setView(Array $suggests);
        return $this->render('suggest', [

        ]);
    }
}