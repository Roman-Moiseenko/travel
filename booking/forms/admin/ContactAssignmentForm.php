<?php


namespace booking\forms\admin;


use booking\entities\admin\ContactAssignment;
use yii\base\Model;

class ContactAssignmentForm extends Model
{
    public $contact_id;
    public $value;
    public $description;

    public function __construct(ContactAssignment $contact = null, $config = [])
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