<?php


namespace booking\repositories\art\event;


use booking\entities\art\event\Event;
use yii\web\NotFoundHttpException;

class EventRepository
{
    public function get($id): Event
    {
        if (!$event = Event::findOne($id)) {
            throw new \DomainException('Событие не найдено');
        }
        return $event;
    }

    public function save(Event $event): void
    {
        if (!$event->save()) {
            throw new \DomainException('Ошибка сохранения События');
        }
    }

    public function remove(Event $event): void
    {
        if (!$event->delete()) {
            throw new \DomainException('Ошибка удаления События');
        }
    }

    public function findBySlug($slug): Event
    {
        if (!$event = Event::findOne(['slug' => $slug])) {
            throw new \DomainException('Событие не найдено');
        }
        return $event;
    }

    public function getByCategory($category_id)
    {
        //TODO Сортировка по Календарю

        //TODO отбор по Assignment!!
        return Event::find()->andWhere(['category_id' => $category_id])->all();
    }

    public function getAll()
    {
        //TODO Сортировка по Календарю

        return Event::find()->all();
    }

    public function find($id):? Event
    {
        if (!$event = Event::findOne($id)) throw new NotFoundHttpException('');
        return $event;
    }
}