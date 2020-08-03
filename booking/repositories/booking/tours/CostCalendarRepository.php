<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\CostCalendar;

class CostCalendarRepository
{
    public function getActual($id)
    {
        return CostCalendar::find()->andWhere(['tours_id' => 'id'])->andWhere(['>', 'tour_at', time()])->all();
    }

    public function getDay($id, $date)
    {
        return CostCalendar::find()->andWhere(['tours_id' => 'id'])->andWhere(['tour_at' => $date])->all();
    }
}