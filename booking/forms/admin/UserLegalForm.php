<?php

namespace booking\forms\admin;

use booking\entities\admin\Legal;
use booking\entities\booking\BookingAddress;
use booking\forms\booking\BookingAddressForm;
use booking\forms\booking\PhotosForm;
use booking\forms\CompositeForm;
use yii\base\Model;

/* @property BookingAddress $address
 * @property PhotosForm $photo
 */
class UserLegalForm extends CompositeForm
{
    public $name;
    public $BIK;
    public $account;
    public $INN;
    public $OGRN;
    public $KPP;
    public $description;
    public $caption;
    public $office;
    public $noticePhone;
    public $noticeEmail;


    public function __construct(Legal $legal = null, $config = [])
    {
        if ($legal) {
            $this->name = $legal->name;
            $this->BIK = $legal->BIK;
            $this->account = $legal->account;
            $this->INN = $legal->INN;
            $this->OGRN = $legal->OGRN;
            $this->KPP = $legal->KPP;
            $this->caption = $legal->caption;
            $this->description = $legal->description;
            $this->address = new BookingAddressForm($legal->address);
            $this->office = $legal->office;
            $this->noticeEmail = $legal->noticeEmail;
            $this->noticePhone = $legal->noticePhone;

        } else {
            $this->address = new BookingAddressForm();
        }
        $this->photo = new PhotosForm();
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'BIK', 'account', 'INN', 'caption', 'description', 'noticePhone', 'noticeEmail'], 'required', 'message' => 'Обязательное поле'],
            ['name', 'string'],
            ['account', 'string', 'length' => 20],
            ['INN', 'string', 'min' => 10, 'max' => 12],
            ['KPP', 'string', 'length' => 9],
            ['BIK', 'string', 'length' => 9],
            ['OGRN', 'string', 'min' => 13, 'max' => 15],
            [['BIK', 'KPP', 'INN', 'account', 'OGRN'], 'match', 'pattern' => '/^[0-9]*$/i'],
            [['caption', 'description', 'office'], 'string'],

            [['noticePhone'], 'match', 'pattern' => '/^[+][0-9]{11}$/i', 'message' => 'Формат +КодНомер, например +79990001111'],
            [['noticeEmail'], 'email'],
        ];
    }

    protected function internalForms(): array
    {
        return ['address', 'photo'];
    }
}