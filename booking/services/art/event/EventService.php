<?php


namespace booking\services\art\event;


use booking\entities\art\event\Event;
use booking\entities\booking\BookingAddress;
use booking\entities\Meta;
use booking\entities\touristic\TouristicContact;
use booking\forms\art\event\EventForm;
use booking\repositories\art\event\CategoryRepository;
use booking\repositories\art\event\EventRepository;

class EventService
{
    /**
     * @var EventRepository
     */
    private $events;
    /**
     * @var CategoryRepository
     */
    private $categories;


    public function __construct(EventRepository $events, CategoryRepository $categories)
    {
        $this->events = $events;
        $this->categories = $categories;
    }

    public function create(EventForm $form): Event
    {
        $event = Event::create(
            $form->name,
            $form->categories->main,
            $form->slug,
            $form->title,
            $form->description,
            $form->content,
            $form->video,
            $form->cost,
        );
        $this->update($event, $form);
        return $event;
    }

    public function edit($id, EventForm $form): void
    {
        $event = $this->events->get($id);
        $event->edit(
            $form->name,
            $form->categories->main,
            $form->slug,
            $form->title,
            $form->description,
            $form->content,
            $form->video,
            $form->cost,
            );
        $this->update($event, $form);
    }

    private function update(Event $event, EventForm $form)
    {
        if ($form->photo->files) $event->setPhoto($form->photo->files[0]);
        $event->setAddress(new BookingAddress(
            $form->address->address,
            $form->address->latitude,
            $form->address->longitude
        ));
        $event->setMeta(new Meta(
            $form->meta->title,
            $form->meta->description,
            $form->meta->keywords
        ));
        $event->setContact(new TouristicContact(
            $form->contact->phone,
            $form->contact->url,
            $form->contact->email
        ));
        foreach ($form->categories->others as $other_id) {
            $category = $this->categories->get($other_id);
            $event->assignCategory($category->id);
        }
        $this->events->save($event);
    }

    public function inactivate(int $id)
    {
        $event = $this->events->get($id);
        $event->inactivate();
        $this->events->save($event);
    }

    public function activate(int $id)
    {
        $event = $this->events->get($id);
        $event->activated();
        $this->events->save($event);
    }

    public function remove($id)
    {
        $event = $this->events->get($id);
        $this->events->remove($event);
    }
}