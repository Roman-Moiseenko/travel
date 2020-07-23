<?php


namespace booking\entities\booking\stays\rules;


use yii\db\ActiveRecord;

/**
 * Class Rules
 * @package booking\entities\booking\stays
 * @property integer $id
 * @property integer $stays_id
 * @property Beds $beds
 * @property Children $children
 * @property Checkin $checkin
 * @property Adelimit $agelimit
 * @property Cards[] $cards
 */
class Rules extends ActiveRecord
{
    public static function create(): self
    {
        $rules = new static();
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
            $this->getAttribute('beds_adult_cost'),
        );

        $this->children = new Children(
            $this->getAttribute('children_on'),
            $this->getAttribute('children_agelimitfree'),
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
        return parent::beforeSave($insert);
    }
}