<?php


namespace booking\forms\touristic;


use booking\entities\touristic\TouristicContact;
use yii\base\Model;

class TouristicContactForm extends Model
{
    public $phone;
    public $url;
    public $email;

    public function __construct(TouristicContact $contact = null, $config = [])
    {
        if ($contact){
            $this->phone = $contact->phone;
            $this->url = $contact->url;
            $this->email = $contact->email;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['email', 'email'],
            ['phone', 'string', 'min' => 10, 'max' => 13, 'message' => 'Неверный номер телефона'],
            ['phone', 'match', 'pattern' => '/^[+][0-9]*$/i', 'message' => 'Неверный номер телефона'],
            ['url', 'url'],
        ];
    }
}