<?php


namespace booking\forms\realtor;


use booking\entities\realtor\Landowner;
use yii\base\Model;

class BookingLandowner extends Model
{
    public $landowner_id;
    public $name;
    public $phone;
    public $email;
    public $period;
    public $wish;

    public function rules()
    {
        return [
            ['landowner_id', 'integer'],
            [['name', 'period', 'wish'], 'string'],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^[+][0-9]*$/i', 'message' => 'Неверный номер телефона'],
            [['landowner_id', 'name', 'phone', 'period'], 'required', 'message' => 'Обязательное поле']
        ];
    }

    public function Landowner():? Landowner
    {
        return $this->landowner_id ? Landowner::findOne($this->landowner_id) : null;
    }
}