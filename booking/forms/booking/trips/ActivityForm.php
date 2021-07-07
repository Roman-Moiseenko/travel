<?php


namespace booking\forms\booking\trips;


use booking\entities\booking\trips\activity\Activity;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;

/**
 * Class ActivityForm
 * @package booking\forms\booking\trips
 * @property PhotosForm $photos
 * @property BookingAddressForm $address
 */
class ActivityForm extends CompositeForm
{
    public $day; // ... день от начала тура, начиная с 1го дня. Если == 0, то это перечень мероприятий по желанию, "согласовываются на месте"
    public $time;  //... пусто, начало, начало-конец
    public $cost;
    public $caption;
    public $caption_en;
    public $description;
    public $description_en;

    public function __construct(Activity $activity = null, $config = [])
    {
        if ($activity) {
            $this->day = $activity->day;
            $this->time = $activity->time;
            $this->caption = $activity->caption;
            $this->caption_en = $activity->caption_en;
            $this->description = $activity->description;
            $this->description_en = $activity->description_en;
            $this->address = new BookingAddressForm($activity->address);
        } else {
            $this->address = new BookingAddressForm();
        }
        $this->photos = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['time', 'caption', 'caption_en', 'description', 'description_en'], 'string'],
            [['day', 'cost'], 'integer', 'min' => 0],
            [['day', 'caption', 'description'], 'required', 'message' => 'Обязательное поле'],
        ];
    }

    protected function internalForms(): array
    {
        return ['photos', 'address'];
    }
}