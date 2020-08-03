<?php


namespace booking\entities\booking\tours;


use understeam\calendar\ActiveRecordItemTrait;
use understeam\calendar\CalendarInterface;
use understeam\calendar\ItemInterface;
use yii\db\ActiveRecord;

/**
 * Class CostCalendar
 * @package booking\entities\booking\tours
 * @property integer $id
 * @property integer $tours_id
 * @property integer $tour_at
 * @property integer $time_at
 * @property integer $tickets
 * @property integer $status
 * @property Cost $cost
 */
class CostCalendar extends ActiveRecord // implements ItemInterface
{
   // use ActiveRecordItemTrait;
    public $cost;

    public static function create($tour_at, $time_at, Cost $cost, $tickets): self
    {
        $calendar = new static();
        $calendar->tour_at = $tour_at;
        $calendar->time_at = $time_at;
        $calendar->tickets = $tickets;
        $calendar->cost = $cost;
        return $calendar;
    }

 /*   public function edit($tour_at, Cost $cost)
    {
        $this->tour_at = $tour_at;
        $this->cost = $cost;
    }
*/
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