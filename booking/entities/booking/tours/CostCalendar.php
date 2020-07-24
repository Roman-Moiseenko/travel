<?php


namespace booking\entities\booking\tours;


use yii\db\ActiveRecord;

/**
 * Class CostCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $tour_id
 * @property integer $tour_at
 * @property Cost $cost
 */
class CostCalendar extends ActiveRecord
{
    public $cost;

    public static function create($tour_at, Cost $cost): self
    {
        $calendar = new static();
        $calendar->tour_at = $tour_at;
        $calendar->cost = $cost;
        return $calendar;
    }

    public function edit($tour_at, Cost $cost)
    {
        $this->tour_at = $tour_at;
        $this->cost = $cost;
    }

    public static function tableName()
    {
        return '{{%booking_tours_calendar_cost}}';
    }

    public function afterFind(): void
    {
        $this->cost = new Cost(
            $this->getAttribute('cost_adult'),
            $this->getAttribute('cost_child'),
            $this->getAttribute('cost_preference'),
        );
        parent::afterFind();
    }

    public function beforeSave($insert): bool
    {
        $this->setAttribute('cost_adult', $this->cost->adult);
        $this->setAttribute('cost_child', $this->cost->child);
        $this->setAttribute('cost_preference', $this->cost->preference);

        return parent::beforeSave($insert);
    }
}