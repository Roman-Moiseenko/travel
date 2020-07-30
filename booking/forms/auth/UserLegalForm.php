<?php

namespace booking\forms\auth;

use booking\entities\admin\user\UserLegal;
use yii\base\Model;

class UserLegalForm extends Model
{
    public $name;
    public $BIK;
    public $account;
    public $INN;
    public $OGRN;
    public $KPP;

    public function __construct(UserLegal $legal = null, $config = [])
    {
        if ($legal) {
            $this->name = $legal->name;
            $this->BIK = $legal->BIK;
            $this->account = $legal->account;
            $this->INN = $legal->INN;
            $this->OGRN = $legal->OGRN;
            $this->KPP = $legal->KPP;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name', 'BIK', 'account', 'INN'], 'required'],
            ['name', 'string'],
            ['account', 'string', 'length' => 20],
            ['INN', 'string', 'min' => 10, 'max' => 12],
            ['KPP', 'string', 'length' => 9],
            ['BIK', 'string', 'length' => 9],
            ['OGRN', 'string', 'min' => 13, 'max' => 15],
            [['BIK', 'KPP', 'INN', 'account', 'OGRN'], 'match', 'pattern' => '/^[0-9]*$/i'],
        ];
    }
}