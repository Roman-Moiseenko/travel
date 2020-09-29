<?php


namespace booking\forms\office\guides;


use booking\entities\admin\Contact;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/**
 * Class ContactLegalForm
 * @package booking\forms\office\guides
 * @property PhotosForm $photo
 */
class ContactLegalForm extends CompositeForm
{
    public $name;
    public $type;
    public $prefix;

    public function __construct(Contact $contact = null, $config = [])
    {
        if ($contact) {
            $this->name = $contact->name;
            $this->type = $contact->type;
            $this->prefix = $contact->prefix;
        }
        $this->photo = new PhotosForm();

        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'prefix'], 'string'],
            ['type', 'integer'],
            ['name', 'required'],
        ];
    }

    protected function internalForms(): array
    {
        return ['photo'];
    }
}