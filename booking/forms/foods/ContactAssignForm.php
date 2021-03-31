<?php


namespace booking\forms\foods;


use booking\entities\foods\ContactAssign;
use yii\base\Model;

class ContactAssignForm  extends Model
{
    public $contact_id;
    public $value;
    public $description;

    public function __construct(ContactAssign $contact = null, $config = [])
    {
        if ($contact != null) {
            $this->contact_id = $contact->contact_id;
            $this->value = $contact->value;
            $this->description = $contact->description;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['contact_id', 'value'], 'required', 'message' => 'Обязательное поле'],
            ['contact_id', 'integer'],
            [['value', 'description'], 'string'],
        ];
    }
}