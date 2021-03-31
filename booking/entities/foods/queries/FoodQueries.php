<?php

namespace booking\entities\foods\queries;

use yii\db\ActiveQuery;

class FoodQueries extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'visible' => true]);
    }

}