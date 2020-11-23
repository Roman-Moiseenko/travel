<?php


namespace booking\entities\booking\tours;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class SellingTour
 * @package booking\entities\booking\tours
 * @property int $id
 * @property int $calendar_id
 * @property int $count
 * @property int $created_at
 * @property CostCalendar $calendar
 */
class SellingTour extends ActiveRecord
{

    public static function create($calendar_id, $count): self
    {
        $selling = new static();
        $selling->calendar_id = $calendar_id;
        $selling->count = $count;
        $selling->created_at = time();
        return $selling;
    }

    public static function tableName()
    {
        return '{{%selling_tour}}';
    }

    public function getCalendar(): ActiveQuery
    {
        return $this->hasOne(CostCalendar::class, ['id' => 'calendar_id']);
    }
}