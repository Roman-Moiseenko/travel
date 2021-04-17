<?php


namespace booking\entities\shops\products\queries;


use booking\helpers\StatusHelper;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([($alias ? $alias . '.' : '') . 'active' => true]);
            //->andWhere(['>', ($alias ? $alias . '.' : '') . 'quantity', 0]);
    }

    public function notEmpty($alias = null)
    {
        return $this->andWhere(['>', ($alias ? $alias . '.' : '') . 'quantity', 0]);
    }
}