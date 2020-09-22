<?php


namespace booking\forms\admin;


use booking\entities\admin\Contact;
use booking\entities\admin\ContactAssignment;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class ContactForm
 * @package booking\forms\admin
 * @property PhotosForm $photo
 */
class ContactForm extends CompositeForm
{

    public $name;
    public $type;
    public $prefix;

    public function __construct(Contact $contact = null, $config = [])
    {
        if ($contact != null) {
            $this->name = $contact->name;
            $this->type = $contact->type;
            $this->prefix = $contact->prefix;
            $this->photo = new PhotosForm($contact->photo);
        } else {
            $this->photo = new PhotosForm();
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            [['name', 'prefix'], 'string'],
            ['type', 'integer']
        ];
    }

    protected function internalForms(): array
    {
        return ['photo'];
    }
}