<?php


namespace booking\entities\booking\stays\rules;


use booking\entities\booking\AgeLimit;
use booking\entities\user\Personal;
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
 * @property string $beds_json [json]
 * @property string $parking_json [json]
 * @property string $checkin_json [json]
 * @property string $limit_json [json]
 */
class Rules extends ActiveRecord
{
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
        $beds = Json::decode($this->getAttribute('beds_json'), true);
        $this->beds = new Beds(
            $beds['beds_child_on'] ?? false,
            $beds['beds_child_agelimit'] ?? 16,
            $beds['beds_child_cost'] ?? 0,
            $beds['beds_child_by_adult'] ?? 0,
            $beds['beds_adult_on'] ?? false,
            $beds['beds_adult_cost'] ?? 0,
            $beds['beds_adult_count'] ?? 0
        );

        $parking = Json::decode($this->getAttribute('parking_json'), true);
        $this->parking = new Parking(
            $parking['parking_on'],
            $parking['parking_free'],
            $parking['parking_private'],
            $parking['parking_inside'],
            $parking['parking_reserve'],
            $parking['parking_cost']
        );

        $checkin = Json::decode($this->getAttribute('checkin_json'), true);
        $this->checkin = new CheckIn(
            $checkin['checkin_fulltime'],
            $checkin['checkin_checkin_from'],
            $checkin['checkin_checkin_to'],
            $checkin['checkin_checkout_from'],
            $checkin['checkin_checkout_to']
        );

        $limit = Json::decode($this->getAttribute('limit_json'), true);
        $this->limit = new Limit(
            $limit['limit_smoking'],
            $limit['limit_animals'],
            $limit['limit_children']
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('beds_json', Json::encode([
            'beds_child_on' => $this->beds->child_on,
            'beds_child_agelimit' => $this->beds->child_agelimit,
            'beds_child_cost' => $this->beds->child_cost,
            'beds_child_by_adult' => $this->beds->child_by_adult,
            'beds_adult_on' => $this->beds->adult_on,
            'beds_adult_cost' => $this->beds->adult_cost,
            'beds_adult_count' => $this->beds->adult_count,
        ]));

        $this->setAttribute('parking_json', Json::encode([
            'parking_on' => $this->parking->on,
            'parking_free' => $this->parking->free,
            'parking_private' => $this->parking->private,
            'parking_inside' => $this->parking->inside,
            'parking_reserve' => $this->parking->reserve,
            'parking_cost' => $this->parking->cost,
        ]));

        $this->setAttribute('checkin_json', Json::encode([
            'checkin_fulltime' => $this->checkin->fulltime,
            'checkin_checkin_from' => $this->checkin->checkin_from,
            'checkin_checkin_to' => $this->checkin->checkin_to,
            'checkin_checkout_from' => $this->checkin->checkout_from,
            'checkin_checkout_to' => $this->checkin->checkout_to,
        ]));

        $this->setAttribute('limit_json', Json::encode([
            'limit_smoking' => $this->limit->smoking,
            'limit_animals' => $this->limit->animals,
            'limit_children' => $this->limit->children,

        ]));
        return parent::beforeSave($insert);
    }
}