<?php


namespace booking\forms\shops;


use booking\entities\shops\Delivery;
use booking\entities\shops\Shop;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class ShopCreateForm
 * @package booking\forms\shops
 * @property DeliveryForm $delivery
 */
class ShopCreateForm extends CompositeForm
{
    public $name;
    public $name_en;
    public $description;
    public $description_en;
    public $legal_id;
    public $type_id;
    /** @var $delivery Delivery */
    public $delivery;

    public function __construct(Shop $shop = null, $config = [])
    {
        if ($shop) {
            $this->name = $shop->name;
            $this->name_en = $shop->name_en;
            $this->description = $shop->description;
            $this->description_en = $shop->description_en;
            $this->type_id = $shop->type_id;
            $this->legal_id = $shop->legal_id;
            $this->delivery = new DeliveryForm($shop->delivery);
        }
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

    protected function internalForms(): array
    {
        return ['delivery'];
    }
}