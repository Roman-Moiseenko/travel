<?php


namespace booking\forms\manage;


use booking\entities\Lang;
use booking\entities\user\FullName;
use yii\base\Model;

class FullNameForm extends Model
{
    public $surname;
    public $firstname;
    public $secondname;

    public function __construct(FullName $fullName = null, $config = [])
    {
        if ($fullName) {
            $this->surname = $fullName->surname;
            $this->firstname = $fullName->firstname;
            $this->secondname = $fullName->secondname;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['surname', 'firstname', 'secondname'], 'string', 'max' => 33],
            [['surname'], 'required', 'message' => 'Заполните это поле'],
            [['firstname'], 'required', 'message' => 'Заполните это поле'],
        ];
    }

}