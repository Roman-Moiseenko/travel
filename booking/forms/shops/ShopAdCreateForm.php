<?php


namespace booking\forms\shops;


use booking\entities\admin\Contact;
use booking\entities\booking\funs\WorkMode;
use booking\entities\shops\AdInfoAddress;
use booking\entities\shops\AdShop;
use booking\forms\booking\funs\WorkModeForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;

use yii\base\Model;

/**
 * Class ShopCreateForm
 * @package booking\forms\shops
 * @property PhotosForm $photos
 * @property ContactAssignForm[] $contactAssign
 * @property AdInfoAddressForm[] $addresses
 * @property WorkModeForm[] $workModes
 */
class ShopAdCreateForm extends CompositeForm
{
    public $name;
    public $name_en;
    public $description;
    public $description_en;
    public $legal_id;
    public $type_id;

    public function __construct(AdShop $shop = null, $config = [])
    {
        $address = [];
        if ($shop) {
            $this->name = $shop->name;
            $this->name_en = $shop->name_en;
            $this->description = $shop->description;
            $this->description_en = $shop->description_en;
            $this->type_id = $shop->type_id;
            $this->legal_id = $shop->legal_id;
            $this->contactAssign = array_map(function (Contact $contact) use ($shop) {
                return new ContactAssignForm($contact, $shop->contactAssignById($contact->id));
            }, Contact::find()->all());

            $address = array_map(function (AdInfoAddress $address) {
                return new AdInfoAddressForm($address);
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
        }
        $n = AdInfoAddress::MAX_ADDRESS - count($address); //добавляем пустые адреса до 99 штук
        for ($i = 0; $i < $n; $i++) {
            $address[] = new AdInfoAddressForm();
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
        ];
    }
    public function beforeValidate(): bool
    {
        $this->addresses = array_filter(array_map(function (AdInfoAddressForm $item) {
            return empty($item->address) ? false : $item;
        }, (array)$this->addresses));
        $this->contactAssign = array_filter(array_map(function (ContactAssignForm $item){
                return empty($item->value) ? false : $item;
            }, (array)$this->contactAssign)
        );

        return parent::beforeValidate();
    }
    protected function internalForms(): array
    {
        return ['photos', 'contactAssign', 'addresses', 'workModes'];
    }
}