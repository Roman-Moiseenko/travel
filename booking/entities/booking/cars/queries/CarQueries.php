<?php


namespace booking\entities\booking\cars\queries;

use booking\helpers\StatusHelper;
use yii\db\ActiveQuery;

class CarQueries extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'status' => StatusHelper::STATUS_ACTIVE]);
    }

    public function verify($alias = null)
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'status' => StatusHelper::STATUS_VERIFY]);
    }
}