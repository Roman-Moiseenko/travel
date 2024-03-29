<?php

namespace booking\entities\photos;


use yii\db\ActiveQuery;

class PageQuery extends ActiveQuery
{
    /**
     * @param null $alias
     * @return $this
     */
    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Page::STATUS_ACTIVE,
        ]);
    }
}