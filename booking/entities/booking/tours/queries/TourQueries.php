<?php

namespace booking\entities\booking\tours\queries;

use booking\helpers\StatusHelper;
use yii\db\ActiveQuery;

class TourQueries extends ActiveQuery
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