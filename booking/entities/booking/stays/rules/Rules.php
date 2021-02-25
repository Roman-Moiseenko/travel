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
 * @property string $beds_json [json]
 * @property string $parking_json [json]
 * @property string $checkin_json [json]
 * @property string $limit_json [json]
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
        $beds = Json::decode($this->getAttribute('beds_json'), true);
        $this->beds = new Beds(
            $beds['beds_child_on'] ?? null,
            $beds['beds_child_agelimit'] ?? null,
            $beds['beds_child_cost'] ?? null,
            $beds['beds_child_by_adult'] ?? null,
            $beds['beds_child_count'] ?? null,
            $beds['beds_adult_on'] ?? null,
            $beds['beds_adult_cost'] ?? null,
            $beds['beds_adult_count'] ?? null
        );

        $parking = Json::decode($this->getAttribute('parking_json'), true);
        $this->parking = new Parking(
            $parking['parking_status'] ?? null,
            $parking['parking_private'] ?? null,
            $parking['parking_inside'] ?? null,
            $parking['parking_reserve'] ?? null,
            $parking['parking_cost'] ?? null,
            $parking['parking_cost_type'] ?? null,
            $parking['parking_security'] ?? null,
            $parking['parking_covered'] ?? null,
            $parking['parking_street'] ?? null,
            $parking['parking_invalid'] ?? null
        );

        $checkin = Json::decode($this->getAttribute('checkin_json'), true);
        $this->checkin = new CheckIn(
            $checkin['checkin_checkin_from'] ?? null,
            $checkin['checkin_checkin_to'] ?? null,
            $checkin['checkin_checkout_from'] ?? null,
            $checkin['checkin_checkout_to'] ?? null,
            $checkin['checkin_message'] ?? null
        );

        $limit = Json::decode($this->getAttribute('limit_json'), true);
        $this->limit = new Limit(
            $limit['limit_smoking'] ?? null,
            $limit['limit_animals'] ?? null,
            $limit['limit_children'] ?? null,
            $limit['limit_children_allow'] ?? null
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
            'beds_child_count' => $this->beds->child_count,
            'beds_adult_on' => $this->beds->adult_on,
            'beds_adult_cost' => $this->beds->adult_cost,
            'beds_adult_count' => $this->beds->adult_count,
        ]));

        $this->setAttribute('parking_json', Json::encode([
            'parking_status' => $this->parking->status,
            'parking_private' => $this->parking->private,
            'parking_inside' => $this->parking->inside,
            'parking_reserve' => $this->parking->reserve,
            'parking_cost' => $this->parking->cost,
            'parking_cost_type' => $this->parking->cost_type,
            'parking_security' => $this->parking->security,
            'parking_covered' => $this->parking->covered,
            'parking_street' => $this->parking->street,
            'parking_invalid' => $this->parking->invalid

        ]));

        $this->setAttribute('checkin_json', Json::encode([
            'checkin_checkin_from' => $this->checkin->checkin_from,
            'checkin_checkin_to' => $this->checkin->checkin_to,
            'checkin_checkout_from' => $this->checkin->checkout_from,
            'checkin_checkout_to' => $this->checkin->checkout_to,
            'checkin_message' => $this->checkin->message,
        ]));

        $this->setAttribute('limit_json', Json::encode([
            'limit_smoking' => $this->limit->smoking,
            'limit_animals' => $this->limit->animals,
            'limit_children' => $this->limit->children,
            'limit_children_allow' => $this->limit->children_allow,
        ]));
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