<?php


namespace booking\entities\admin\user;


use yii\db\ActiveRecord;

/**
 * Class UserLegal
 * @package booking\entities\admin\user
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $INN
 * @property string $KPP
 * @property string $OGRN
 * @property string $BIK
 * @property string $account
 */
class UserLegal extends ActiveRecord
{

    public static function create($name, $BIK, $account, $INN, $OGRN = null, $KPP = null): self
    {
        $legal = new static();
        $legal->name = $name;
        $legal->BIK = $BIK;
        $legal->account = $account;
        $legal->INN = $INN;
        $legal->OGRN = $OGRN;
        $legal->KPP = $KPP;
        return $legal;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function edit($name, $BIK, $account, $INN, $OGRN = null, $KPP = null): void
    {
        $this->name = $name;
        $this->BIK = $BIK;
        $this->account = $account;
        $this->INN = $INN;
        $this->OGRN = $OGRN;
        $this->KPP = $KPP;
    }

    public static function tableName()
    {
        return '{{%admin_user_legals}}';
    }

}