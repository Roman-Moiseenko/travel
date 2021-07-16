<?php


namespace booking\entities\realtor_old;


use booking\entities\behaviors\BookingAddressBehavior;
use booking\entities\behaviors\FullnameBehavior;
use booking\entities\booking\BookingAddress;
use booking\entities\user\FullName;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Landowner
 * @package booking\entities\realtor
 * @property integer $id
 * @property string $caption ... ФИО или ООО
 * @property string $phone
 * @property string $email
 * @property Plot[] $plots
 */
class Landowner extends ActiveRecord
{

    /** @var $address BookingAddress */
    public $address;

    /** @var $agent FullName */
    public $person;

    public static function create($caption, $phone, $email, BookingAddress $address, FullName $person): self
    {
        $landowner = new static();
        $landowner->caption = $caption;
        $landowner->phone = $phone;
        $landowner->email = $email;
        $landowner->address = $address;
        $landowner->person = $person;
        return $landowner;
    }

    public function edit($caption, $phone, $email, BookingAddress $address, FullName $person): void
    {
        $this->caption = $caption;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->person = $person;
    }

    public function behaviors()
    {
        return [
            BookingAddressBehavior::class,
            FullnameBehavior::class,
        ];
    }

    public static function tableName()
    {
        return '{{%realtor_landowners}}';
    }


    public function getPlots(): ActiveQuery
    {
        return $this->hasMany(Plot::class, ['landowner_id' => 'id']);
    }
}