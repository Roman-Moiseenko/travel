<?php


namespace booking\forms\events;


use booking\entities\admin\Contact;
use booking\entities\events\ContactAssign;
use yii\base\Model;

class ContactAssignForm  extends Model
{
    public $value;
    public $description;
    /** @var Contact $_contact */
    public $_contact;

    public function __construct(Contact $contact, ContactAssign $assign = null, $config = [])
    {
        $this->_contact = $contact;
        if ($assign) {
            $this->value = $assign->value;
            $this->description = $assign->description;
        }
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['value', 'description'], 'string'],
        ];
    }
}