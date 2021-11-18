<?php


namespace booking\forms\art\event;


use booking\entities\art\event\Event;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use booking\forms\touristic\TouristicContactForm;

/**
 * Class EventForm
 * @package booking\forms\art\event
 * @property PhotosForm $photo
 * @property MetaForm $meta
 * @property BookingAddressForm $address
 * @property TouristicContactForm $contact
 * @property CategoriesAssignmentForm $categories
 */
class EventForm extends CompositeForm
{
    public $name;
    public $slug;
    public $title;
    public $description;
    public $content;
    public $video;
    public $cost;

    public function __construct(Event $event = null, $config = [])
    {
        if ($event) {
            $this->name = $event->name;
            $this->slug = $event->slug;
            $this->title = $event->title;
            $this->description = $event->description;
            $this->content = $event->content;
            $this->video = $event->video;
            $this->cost = $event->cost;

            $this->address = new BookingAddressForm($event->address);
            $this->meta = new MetaForm($event->meta);
            $this->address = new BookingAddressForm($event->address);
            $this->contact = new TouristicContactForm($event->contact);
        } else {
            $this->address = new BookingAddressForm();
            $this->meta = new MetaForm();
            $this->address = new BookingAddressForm();
            $this->contact = new TouristicContactForm();
        }

        $this->categories = new CategoriesAssignmentForm($event);
        $this->photo = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug', 'title', 'description', 'content', 'video'], 'string'],
            [['name', 'title', 'description', 'content'], 'required'],
            [['cost'], 'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return ['photo', 'meta', 'address', 'contact', 'categories'];
    }
}