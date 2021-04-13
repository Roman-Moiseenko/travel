<?php


namespace booking\entities\shops\products\queries;


use booking\helpers\StatusHelper;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this
            ->andWhere([($alias ? $alias . '.' : '') . 'status' => StatusHelper::STATUS_ACTIVE])
            ->andWhere(['>', ($alias ? $alias . '.' : '') . 'quantity', 0]);
    }
}