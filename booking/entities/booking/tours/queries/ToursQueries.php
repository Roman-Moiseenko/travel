<?php


namespace booking\entities\booking\tours\queries;


use booking\entities\booking\tours\Tours;
use yii\db\ActiveQuery;

class ToursQueries extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'status' => Tours::STATUS_ACTIVE]);
    }
}