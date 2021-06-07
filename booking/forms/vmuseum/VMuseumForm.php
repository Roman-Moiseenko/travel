<?php


namespace booking\forms\vmuseum;


use booking\entities\admin\Contact;
use booking\entities\vmuseum\VMuseum;
use booking\entities\WorkMode;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\MetaForm;
use booking\forms\WorkModeForm;
use yii\base\Model;

/**
 * Class VMuseumForm
 * @package booking\forms\vmuseum
 * @property PhotosForm $photos
 * @property ContactAssignForm[] $contactAssign
 * @property BookingAddressForm $address
 * @property WorkModeForm[] $workModes
 * @property MetaForm $meta
 */
class VMuseumForm extends CompositeForm
{
    public $name;
    public $name_en;
    public $description;
    public $description_en;
    public $slug;
    public $fun_id;

    public function __construct(VMuseum $vMuseum = null, $config = [])
    {
        if ($vMuseum) {
            $this->name = $vMuseum->name;
            $this->name_en = $vMuseum->name_en;
            $this->description = $vMuseum->description;
            $this->description_en = $vMuseum->description_en;
            $this->slug = $vMuseum->slug;
            $this->fun_id = $vMuseum->fun_id;

            $this->contactAssign = array_map(function (Contact $contact) use ($vMuseum) {
                return new ContactAssignForm($contact, $vMuseum->contactAssignById($contact->id));
            }, Contact::find()->all());

            $this->workModes = array_map(function (WorkMode $workMode) {
                return new WorkModeForm($workMode);
            }, $vMuseum->workModes);

            $this->address = new BookingAddressForm($vMuseum->address);

            $this->meta = new MetaForm($vMuseum->meta);
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
            [['name_en', 'name', 'description', 'description_en', 'slug'], 'string'],
            ['fun_id', 'integer'],
        ];
    }

    public function beforeValidate()
    {
        $this->contactAssign = array_filter(array_map(function (ContactAssignForm $item) {
                return empty($item->value) ? false : $item;
            }, (array)$this->contactAssign)
        );
        return parent::beforeValidate();
    }

    protected function internalForms(): array
    {
        return ['photos', 'contactAssign', 'address', 'workModes', 'meta'];

    }
}