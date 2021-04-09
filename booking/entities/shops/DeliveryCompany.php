<?php


namespace booking\entities\shops;


use yii\db\ActiveRecord;

/**
 * Class DeliveryCompany
 * @package booking\entities\shops
 * @property integer $id
 * @property integer $name
 * @property string $link - ссылка на сайт
 * @property string $api_json [json]
 ***** --- возможно доп поля для api
 */
class DeliveryCompany extends ActiveRecord
{

    public static function create($name, $link): self
    {
        $company = new static();
        $company->name = $name;
        $company->link = $link;
        return $company;
    }

    public function api($api_json): void
    {
        $this->api_json = $api_json;
    }

    public function edit($name, $link): void
    {
        $this->name = $name;
        $this->link = $link;
    }

    public static function tableName()
    {
        return '{{%shops_delivery_company}}';
    }
}