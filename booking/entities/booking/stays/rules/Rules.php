<?php


namespace booking\entities\booking\stays\rules;


use booking\entities\booking\AgeLimit;
use booking\entities\Lang;
use booking\entities\user\Personal;
use booking\helpers\scr;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class Rules
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $stay_id
 *
 * @property Beds $beds
 * @property CheckIn $checkin
 * @property Parking $parking
 * @property Limit $limit
 *
 * @property bool $beds_child_on [tinyint(1)]
 * @property int $beds_child_agelimit [int]
 * @property int $beds_child_cost [int]
 * @property int $beds_child_by_adult [int]
 * @property int $beds_child_count [int]
 * @property bool $beds_adult_on [tinyint(1)]
 * @property int $beds_adult_cost [int]
 * @property int $beds_adult_count [int]
 * @property int $parking_status [int]
 * @property bool $parking_private [tinyint(1)]
 * @property bool $parking_inside [tinyint(1)]
 * @property bool $parking_reserve [tinyint(1)]
 * @property int $parking_cost [int]
 * @property int $parking_cost_type [int]
 * @property bool $parking_security [tinyint(1)]
 * @property bool $parking_covered [tinyint(1)]
 * @property bool $parking_street [tinyint(1)]
 * @property bool $parking_invalid [tinyint(1)]
 * @property int $checkin_checkin_from [int]
 * @property int $checkin_checkin_to [int]
 * @property int $checkin_checkout_from [int]
 * @property int $checkin_checkout_to [int]
 * @property bool $checkin_message [tinyint(1)]
 * @property bool $limit_smoking [tinyint(1)]
 * @property int $limit_animals [int]
 * @property bool $limit_children [tinyint(1)]
 * @property int $limit_children_allow [int]
 *

 */
class Rules extends ActiveRecord
{
    const STATUS_NOT = 11;
    const STATUS_FREE = 12;
    const STATUS_PAY = 13;

    public static function create(): self
    {
        $rules = new static();
        $rules->beds = new Beds();
        $rules->parking = new Parking();
        $rules->checkin = new CheckIn();
        $rules->limit = new Limit();
        return $rules;
    }

    public function setBeds(Beds $beds)
    {
        $this->beds = $beds;
    }

    public function setParking(Parking $parking)
    {
        $this->parking = $parking;
    }

    public function setCheckin(CheckIn $checkin)
    {
        $this->checkin = $checkin;
    }

    public function setLimit(Limit $limit)
    {
        $this->limit = $limit;
    }

    public static function tableName()
    {
        return '{{%booking_stays_rules}}';
    }


    public function afterFind(): void
    {
        $this->beds = new Beds(
            $this->getAttribute('beds_child_on'),
            $this->getAttribute('beds_child_agelimit'),
            $this->getAttribute('beds_child_cost'),
            $this->getAttribute('beds_child_by_adult'),
            $this->getAttribute('beds_child_count'),
            $this->getAttribute('beds_adult_on'),
            $this->getAttribute('beds_adult_cost'),
            $this->getAttribute('beds_adult_count')
        );

        $this->parking = new Parking(
            $this->getAttribute('parking_status'),
            $this->getAttribute('parking_private'),
            $this->getAttribute('parking_inside'),
            $this->getAttribute('parking_reserve'),
            $this->getAttribute('parking_cost'),
            $this->getAttribute('parking_cost_type'),
            $this->getAttribute('parking_security'),
            $this->getAttribute('parking_covered'),
            $this->getAttribute('parking_street'),
            $this->getAttribute('parking_invalid')
        );

        $this->checkin = new CheckIn(
            $this->getAttribute('checkin_checkin_from'),
            $this->getAttribute('checkin_checkin_to'),
            $this->getAttribute('checkin_checkout_from'),
            $this->getAttribute('checkin_checkout_to'),
            $this->getAttribute('checkin_message')
        );

        $this->limit = new Limit(
            $this->getAttribute('limit_smoking'),
            $this->getAttribute('limit_animals'),
            $this->getAttribute('limit_children'),
            $this->getAttribute('limit_children_allow')
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('beds_child_on', $this->beds->child_on);
        $this->setAttribute('beds_child_agelimit', $this->beds->child_agelimit);
        $this->setAttribute('beds_child_cost', $this->beds->child_cost);
        $this->setAttribute('beds_child_by_adult', $this->beds->child_by_adult);
        $this->setAttribute('beds_child_count', $this->beds->child_count);
        $this->setAttribute('beds_adult_on', $this->beds->adult_on);
        $this->setAttribute('beds_adult_cost', $this->beds->adult_cost);
        $this->setAttribute('beds_adult_count', $this->beds->adult_count);

        $this->setAttribute('parking_status', $this->parking->status);
        $this->setAttribute('parking_private', $this->parking->private);
        $this->setAttribute('parking_inside', $this->parking->inside);
        $this->setAttribute('parking_reserve', $this->parking->reserve);
        $this->setAttribute('parking_cost', $this->parking->cost);
        $this->setAttribute('parking_cost_type', $this->parking->cost_type);
        $this->setAttribute('parking_security', $this->parking->security);
        $this->setAttribute('parking_covered', $this->parking->covered);
        $this->setAttribute('parking_street', $this->parking->street);
        $this->setAttribute('parking_invalid', $this->parking->invalid);

        $this->setAttribute('checkin_checkin_from', $this->checkin->checkin_from);
        $this->setAttribute('checkin_checkin_to', $this->checkin->checkin_to);
        $this->setAttribute('checkin_checkout_from', $this->checkin->checkout_from);
        $this->setAttribute('checkin_checkout_to', $this->checkin->checkout_to);
        $this->setAttribute('checkin_message', $this->checkin->message);

        $this->setAttribute('limit_smoking', $this->limit->smoking);
        $this->setAttribute('limit_animals', $this->limit->animals);
        $this->setAttribute('limit_children', $this->limit->children);
        $this->setAttribute('limit_children_allow', $this->limit->children_allow);

        return parent::beforeSave($insert);
    }

    public static function listStatus(): array
    {
        return [
            self::STATUS_NOT => Lang::t('Нет'),
            self::STATUS_FREE => Lang::t('Да, бесплатно'),
            self::STATUS_PAY => Lang::t('Да, платно'),
        ];
    }
}