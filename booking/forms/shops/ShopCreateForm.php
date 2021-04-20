<?php


namespace booking\forms\shops;


use booking\entities\admin\Contact;
use booking\entities\booking\funs\WorkMode;
use booking\entities\shops\InfoAddress;
use booking\entities\shops\Shop;
use booking\forms\WorkModeForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\InfoAddressForm;
use booking\helpers\scr;

/**
 * Class ShopCreateForm
 * @package booking\forms\shops
 * @property DeliveryForm $delivery
 * @property PhotosForm $photos
 * @property ContactAssignForm[] $contactAssign
 * @property InfoAddressForm[] $addresses
 * @property WorkModeForm[] $workModes
 */
class ShopCreateForm extends CompositeForm
{
    public $ad;
    public $name;
    public $name_en;
    public $description;
    public $description_en;
    public $legal_id;
    public $type_id;


    public function __construct(Shop $shop = null, $config = [])
    {
        $address = [];
        if ($shop) {
            $this->ad = $shop->ad;
            $this->name = $shop->name;
            $this->name_en = $shop->name_en;
            $this->description = $shop->description;
            $this->description_en = $shop->description_en;
            $this->type_id = $shop->type_id;
            $this->legal_id = $shop->legal_id;

            $this->delivery = new DeliveryForm($shop->delivery);

            $this->contactAssign = array_map(function (Contact $contact) use ($shop) {
                return new ContactAssignForm($contact, $shop->contactAssignById($contact->id));
            }, Contact::find()->all());

            $address = array_map(function (InfoAddress $address) {
                return new InfoAddressForm($address);
            }, $shop->addresses);

            $this->workModes = array_map(function (WorkMode $workMode) {
                return new WorkModeForm($workMode);
            }, $shop->workModes);
        } else {
            $this->contactAssign = array_map(function (Contact $contact) {
                return new ContactAssignForm($contact);
            }, Contact::find()->all());

            $_w = [];
            for ($i = 0; $i < 7; $i++) $_w[] = new WorkModeForm();
            $this->workModes = $_w;

            $this->delivery = new DeliveryForm();
        }

        $n = InfoAddress::MAX_ADDRESS - count($address); //добавляем пустые адреса до 99 штук
        for ($i = 0; $i < $n; $i++) {
            $address[] = new InfoAddressForm();
        }
        $this->addresses = $address;

        $this->photos = new PhotosForm();

        parent::__construct($config);

    }

    public function rules()
    {
        return [
            [['name', 'name_en', 'description', 'description_en'], 'string'],
            [['name', 'description', 'type_id', 'legal_id'], 'required'],
            [['type_id', 'legal_id'], 'integer'],
            ['ad', 'boolean'],
        ];
    }

    protected function internalForms(): array
    {
        return ['delivery', 'photos', 'contactAssign', 'addresses', 'workModes'];
    }

    public function beforeValidate(): bool
    {
        $this->addresses = array_filter(array_map(function (InfoAddressForm $item) {
            return empty($item->address) ? false : $item;
        }, (array)$this->addresses));
        $this->contactAssign = array_filter(array_map(function (ContactAssignForm $item) {
                return empty($item->value) ? false : $item;
            }, (array)$this->contactAssign)
        );
        if ($this->ad != true)
            if (count($this->delivery->deliveryCompany) == 0) throw new \DomainException('Не выбрана хотя бы одна транспортная компания!');
        return parent::beforeValidate();
    }

    public function load($data, $formName = null)
    {
        $success = parent::load($data, $formName);
        //scr::v($success);
        return $success;
    }
}