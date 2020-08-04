<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\CostCalendar;

class CostCalendarRepository
{
    public function getActual($id)
    {
        return CostCalendar::find()->andWhere(['tours_id' => $id])->andWhere(['>', 'tour_at', time()])->all();
    }
    public function getActualForCalendar($id)
    {
        return CostCalendar::find()->andWhere(['tours_id' => $id])->andWhere(['>', 'tour_at', time()])->all();
    }
    public function getDay($id, $date)
    {
        return CostCalendar::find()->andWhere(['tours_id' => $id])->andWhere(['tour_at' => $date])->orderBy(['time_at' => SORT_ASC])->all();
    }

    public function getActualInterval($id, $min, $max)
    {
        return CostCalendar::find()
            ->andWhere(['tours_id' => $id])
            ->andWhere(['>=', 'tour_at', $min])
            ->andWhere(['<=', 'tour_at', $max])
            ->all();
    }
}