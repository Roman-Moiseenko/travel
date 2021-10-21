<?php


namespace booking\forms\moving;


use booking\entities\moving\agent\Agent;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\manage\FullNameForm;

/**
 * Class AgentForm
 * @package booking\forms\moving
 *
 * @property FullNameForm $person
 * @property BookingAddressForm $address
 * @property PhotosForm $photo
 */
class AgentForm extends CompositeForm
{
    public $email;
    public $phone;
    public $description;
    public $type;
    public $region_id;


    public function __construct(Agent $agent = null, $config = [])
    {
        if ($agent) {
            $this->email = $agent->email;
            $this->phone = $agent->phone;
            $this->description = $agent->description;
            $this->type = $agent->type;
            $this->region_id = $agent->region_id;

            $this->address = new BookingAddressForm($agent->address);
            $this->person = new FullNameForm($agent->person);
        } else {
            $this->address = new BookingAddressForm();
            $this->person = new FullNameForm();
        }
        $this->photo = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['email', 'phone', 'region_id', 'type', 'region_id'], 'required'],
            ['description', 'string'],
            ['phone', 'string', 'min' => 10, 'max' => 13, 'message' => 'Неверный номер телефона'],
            ['phone', 'match', 'pattern' => '/^[+][0-9]*$/i', 'message' => 'Неверный номер телефона'],
            ['email', 'email'],
            [['region_id', 'type'], 'integer'],
        ];
    }

    protected function internalForms(): array
    {
        return ['person', 'address', 'photo'];
    }
}