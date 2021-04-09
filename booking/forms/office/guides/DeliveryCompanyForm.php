<?php


namespace booking\forms\office\guides;


use booking\entities\shops\DeliveryCompany;
use yii\base\Model;

class DeliveryCompanyForm extends Model
{
    public $name;
    public $link;
    public $api_json;

    public function __construct(DeliveryCompany $company = null, $config = [])
    {
        if ($company) {
            $this->name = $company->name;
            $this->link = $company->link;
            $this->api_json = $company->api_json;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'link', 'api_json'], 'string'],
        ];
    }
}