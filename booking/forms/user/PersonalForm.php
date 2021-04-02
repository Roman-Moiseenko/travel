<?php


namespace booking\forms\user;


use booking\entities\Lang;
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
    public $datebornform;
    public $agreement;

    public function __construct(PersonalInterface $personal, $config = [])
    {
        $this->datebornform = $personal->dateborn ? date('d-m-Y', $personal->dateborn) : '';
        $this->phone = $personal->phone;
        $this->address = new UserAddressForm($personal->address);
        $this->fullname = new FullNameForm($personal->fullname);
        $this->photo = new PhotosForm();
        $this->agreement = $personal->agreement;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['datebornform', 'safe'],
            ['phone', 'string', 'min' => 10, 'max' => 13, 'message' => Lang::t('Неверный номер телефона')],
            ['phone', 'match', 'pattern' => '/^[+][0-9]*$/i', 'message' => Lang::t('Неверный номер телефона')],
            [['phone'], 'required', 'message' => Lang::t('Заполните это поле')],

            ['agreement', 'boolean'],
            ['agreement', 'compare', 'compareValue' => true, 'operator' => '==', 'message' => Lang::t('Необходимо согласие')],
        ];
    }

    protected function internalForms(): array
    {
        return ['photo', 'address', 'fullname'];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (empty($this->datebornform)) {
                $this->dateborn = null;
            } else {
                $this->dateborn = strtotime($this->datebornform . '00:00:00');
            }
            return true;
        }
        return false;
    }
}