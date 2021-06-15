<?php


namespace booking\forms\events;


use booking\entities\admin\Contact;
use booking\entities\events\Provider;
use booking\entities\WorkMode;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use booking\forms\WorkModeForm;

/**
 * Class ProviderForm
 * @package booking\forms\events
 * @property PhotosForm $photos
 * @property ContactAssignForm[] $contactAssign
 * @property BookingAddressForm $address
 * @property WorkModeForm[] $workModes
 * @property MetaForm $meta
 */
class ProviderForm extends CompositeForm
{
    public $fun_id;
    public $name;
    public $name_en;
    public $description;
    public $description_en;
    public $slug;

    public function __construct(Provider $provider = null, $config = [])
    {
        if ($provider) {
            $this->name = $provider->name;
            $this->name_en = $provider->name_en;
            $this->description = $provider->description;
            $this->description_en = $provider->description_en;
            $this->slug = $provider->slug;
            $this->fun_id = $provider->fun_id;
            $this->contactAssign = array_map(function (Contact $contact) use ($provider) {
                return new ContactAssignForm($contact, $provider->contactAssignById($contact->id));
            }, Contact::find()->all());

            $this->workModes = array_map(function (WorkMode $workMode) {
                return new WorkModeForm($workMode);
            }, $provider->workModes);

            $this->address = new BookingAddressForm($provider->address);

            $this->meta = new MetaForm($provider->meta);
        } else {
            $this->contactAssign = array_map(function (Contact $contact) {
                return new ContactAssignForm($contact);
            }, Contact::find()->all());

            $_w = [];
            for ($i = 0; $i < 7; $i++) $_w[] = new WorkModeForm();
            $this->workModes = $_w;
            $this->address = new BookingAddressForm();
            $this->meta = new MetaForm();
        }
        $this->photos = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['fun_id', 'integer'],
            [['name', 'name_en', 'description', 'description_en', 'slug'], 'string'],
            [['name', 'description'], 'required'],
        ];
    }

    protected function internalForms(): array
    {
        return ['photos', 'contactAssign', 'address', 'workModes', 'meta'];
    }
}