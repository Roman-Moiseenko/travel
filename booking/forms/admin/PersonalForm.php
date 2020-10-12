<?php


namespace booking\forms\admin;


use booking\entities\PersonalInterface;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use booking\forms\manage\FullNameForm;
use booking\forms\manage\UserAddressForm;

/**
 * Class PersonalForm
 * @package booking\forms\admin
 * @property UserAddressForm $address
 * @property PhotosForm $photo
 * @property FullNameForm $fullname
 */
class PersonalForm extends CompositeForm
{
    public $dateborn;
    public $phone;
    public $position;
    public $datebornform;

    public function __construct(PersonalInterface $personal, $config = [])
    {
        $this->datebornform = date('d-m-Y', $personal->dateborn);
        $this->phone = $personal->phone;
        $this->position = $personal->position ?? null;
        $this->address = new UserAddressForm($personal->address);
        $this->fullname = new FullNameForm($personal->fullname);
        $this->photo = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['position'], 'string'],
            ['datebornform', 'safe'],
            ['phone', 'string', 'min' => 10, 'max' => 13],
            ['phone', 'match', 'pattern' => '/^[+][0-9]*$/i'],
            ['phone', 'required'],
        ];
    }

    protected function internalForms(): array
    {
        return ['photo', 'address', 'fullname'];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->dateborn = strtotime($this->datebornform . '00:00:00');
            return true;
        }
        return false;
    }
}