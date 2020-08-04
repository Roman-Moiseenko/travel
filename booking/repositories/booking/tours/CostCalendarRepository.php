<?php


namespace booking\repositories\booking\tours;


use booking\entities\booking\tours\CostCalendar;

class CostCalendarRepository
{
    public function get($id)
    {
        return CostCalendar::findOne($id);
    }

    public function getActual($tours_id)
    {
        return CostCalendar::find()->andWhere(['tours_id' => $tours_id])->andWhere(['>', 'tour_at', time()])->all();
    }
    public function getActualForCalendar($tours_id)
    {
        return CostCalendar::find()->andWhere(['tours_id' => $tours_id])->andWhere(['>', 'tour_at', time()])->all();
    }
    public function getDay($tours_id, $date)
    {
        return CostCalendar::find()->andWhere(['tours_id' => $tours_id])->andWhere(['tour_at' => $date])->orderBy(['time_at' => SORT_ASC])->all();
    }

    public function getActualInterval($tours_id, $min, $max)
    {
        return CostCalendar::find()
            ->andWhere(['tours_id' => $tours_id])
            ->andWhere(['>=', 'tour_at', $min])
            ->andWhere(['<=', 'tour_at', $max])
            ->all();
    }
}