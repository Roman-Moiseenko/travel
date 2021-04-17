<?php


namespace booking\entities\shops\products\queries;


use booking\helpers\StatusHelper;
use yii\db\ActiveQuery;

class AdProductQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this
            ->andWhere([($alias ? $alias . '.' : '') . 'active' => true]);
    }
}