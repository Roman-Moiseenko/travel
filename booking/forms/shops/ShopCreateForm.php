<?php


namespace booking\forms\shops;


use booking\entities\shops\Shop;
use yii\base\Model;

class ShopCreateForm extends Model
{
    public $name;
    public $slug;
    public $name_en;
    public $description;
    public $description_en;
    public $legal_id;
    public $type_id;

    public function __construct(Shop $shop = null, $config = [])
    {
        if ($shop) {
            $this->name = $shop->name;
            $this->slug = $shop->slug;
            $this->name_en = $shop->name_en;
            $this->description = $shop->description;
            $this->description_en = $shop->description_en;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'slug', 'name_en', 'description', 'description_en'], 'string'],
            [['name', 'description', 'type_id', 'legal_id'], 'required'],
            [['type_id', 'legal_id'], 'integer']
        ];
    }
}