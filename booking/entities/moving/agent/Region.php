<?php


namespace booking\entities\moving\agent;


use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Class Region
 * @package booking\entities\moving\agent
 * @property $id
 * @property $name;
 * @property $sort
 * @property $link ... ссылка на форум
 * @property Agent[] $agents
 */
class Region extends ActiveRecord
{
    public static function create($name, $link): self
    {
        $region = new static();
        $region->name = $name;
        $region->link = $link;
        return $region;
    }

    public function edit($name, $link): void
    {
        $this->name = $name;
        $this->link = $link;
    }

    public function isFor($id): bool
    {
        return $this->id == $id;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }

    public static function tableName()
    {
        return '{{%moving_regions}}';
    }

    public function getAgents(): ActiveQuery
    {
        return $this->hasMany(Agent::class, ['region_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }
}