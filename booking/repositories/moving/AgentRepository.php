<?php


namespace booking\repositories\moving;


use booking\entities\moving\agent\Agent;

class AgentRepository
{
    public function get($id): Agent
    {
        if (!$agent = Agent::findOne($id)) {
            throw new \DomainException('Представитель не найден.');
        }
        return $agent;
    }

    public function save(Agent $agent): void
    {
        if (!$agent->save()) {
            throw new \DomainException('Ошибка сохранения Представителя.');
        }
    }
    public function remove(Agent $agent): void
    {
        if (!$agent->delete()) {
            throw new \DomainException('Ошибка удаления Представителя.');
        }
    }

    public function getMaxSort($region_id)
    {
        return Agent::find()->where(['region_id' => $region_id])->max('sort');
    }

    public function getAll($region_id)
    {
        return Agent::find()->where(['region_id' => $region_id])->all();
    }
}