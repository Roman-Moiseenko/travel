<?php


namespace booking\forms\manage;


use booking\entities\user\UserAddress;
use yii\base\Model;

class UserAddressForm extends Model
{
    public $country;
    public $town;
    public $address;
    public $index;

    public function __construct(UserAddress $address, $config = [])
    {
        if ($address) {
            $this->country = $address->country;
            $this->town = $address->town;
            $this->address = $address->address;
            $this->index = $address->index;
        }
        parent::__construct($config);
    }
    public function rules()
    {
        return [
            [['town', 'address', 'index'], 'required'],
            [['town', 'address', 'country'], 'string'],
            ['index', 'string', 'length' => 6],
            ['index', 'match', 'pattern' => '/^[0-9]*$/i'],
        ];
    }
}