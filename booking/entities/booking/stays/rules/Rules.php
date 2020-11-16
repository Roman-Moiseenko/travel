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
 * @property integer $stays_id
 * @property Beds $beds
 * @property Children $children
 * @property CheckIn $checkin
 * @property Agelimit $agelimit
 * @property Cards $cards
 * @property Parking $parking
 */
class Rules extends ActiveRecord
{
    public static function create(): self
    {
        $rules = new static();
        //TODO Возможно сделать установку всех Rules, через передачу параметров
        return $rules;
    }

    public function setBeds(Beds $beds)
    {
        $this->beds = $beds;
    }

    public function setChildren(Children $children)
    {
        $this->children = $children;
    }

    public static function tableName()
    {
        return '{{%booking_stays_rules}}';
    }

    public function setParking(Parking $parking)
    {
        $this->parking = $parking;
    }

    public function setCheckin(CheckIn $checkin)
    {
        $this->checkin = $checkin;
    }

    public function setAgelimit(Agelimit $agelimit)
    {
        $this->agelimit = $agelimit;
    }

    public function setCards(Cards $cards)
    {
        $this->cards = $cards;
    }

    public function afterFind(): void
    {

        $this->beds = new Beds(
            $this->getAttribute('beds_on'),
            $this->getAttribute('beds_count'),
            $this->getAttribute('beds_upto2_on'),
            $this->getAttribute('beds_upto2_cost'),
            $this->getAttribute('beds_child_on'),
            $this->getAttribute('beds_child_agelimit'),
            $this->getAttribute('beds_child_cost'),
            $this->getAttribute('beds_adult_on'),
            $this->getAttribute('beds_adult_cost')
        );

        $this->children = new Children(
            $this->getAttribute('children_on'),
            $this->getAttribute('children_agelimitfree')
        );

        $this->parking = new Parking(
            $this->getAttribute('parking_on'),
            $this->getAttribute('parking_free'),
            $this->getAttribute('parking_private'),
            $this->getAttribute('parking_inside'),
            $this->getAttribute('parking_reserve'),
            $this->getAttribute('parking_cost')
        );
        $this->checkin = new CheckIn(
            $this->getAttribute('checkin_fulltime'),
            $this->getAttribute('checkin_checkin_from'),
            $this->getAttribute('checkin_checkint_to'),
            $this->getAttribute('checkin_checkout_from'),
            $this->getAttribute('checkin_checkout_to')
        );

        $this->agelimit = new AgeLimit(
            $this->getAttribute('agelimit_on'),
            $this->getAttribute('agelimit_ageMin'),
            $this->getAttribute('agelimit_ageMax')
        );

        $this->cards = new Cards(
            $this->getAttribute('cards_on'),
            $this->getAttribute(Json::decode('cards_list', true))
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {

        $this->setAttribute('beds_on', $this->beds->on);
        $this->setAttribute('beds_count', $this->beds->count);
        $this->setAttribute('beds_upto2_on', $this->beds->upto2_on);
        $this->setAttribute('beds_upto2_cost', $this->beds->upto2_cost);
        $this->setAttribute('beds_child_on', $this->beds->child_on);
        $this->setAttribute('beds_child_agelimit', $this->beds->child_agelimit);
        $this->setAttribute('beds_child_cost', $this->beds->child_cost);
        $this->setAttribute('beds_adult_on', $this->beds->adult_on);
        $this->setAttribute('beds_adult_cost', $this->beds->adult_cost);

        $this->setAttribute('children_on', $this->children->on);
        $this->setAttribute('children_agelimitfree', $this->children->agelimitfree);

        $this->setAttribute('parking_on', $this->parking->on);
        $this->setAttribute('parking_free', $this->parking->free);
        $this->setAttribute('parking_private', $this->parking->private);
        $this->setAttribute('parking_inside', $this->parking->inside);
        $this->setAttribute('parking_reserve', $this->parking->reserve);
        $this->setAttribute('parking_cost', $this->parking->cost);

        $this->setAttribute('checkin_fulltime', $this->checkin->fulltime);
        $this->setAttribute('checkin_checkin_from', $this->checkin->checkin_from);
        $this->setAttribute('checkin_checkint_to', $this->checkin->checkint_to);
        $this->setAttribute('checkin_checkout_from', $this->checkin->checkout_from);
        $this->setAttribute('checkin_checkout_to', $this->checkin->checkout_to);

        $this->setAttribute('agelimit_on', $this->agelimit->on);
        $this->setAttribute('agelimit_ageMin', $this->agelimit->ageMin);
        $this->setAttribute('agelimit_ageMax', $this->agelimit->ageMax);

        $this->setAttribute('cards_on', $this->cards->on);
        $this->setAttribute('cards_list', Json::encode($this->cards->list));

        return parent::beforeSave($insert);
    }
}