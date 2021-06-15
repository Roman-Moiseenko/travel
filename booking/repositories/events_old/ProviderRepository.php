<?php


namespace booking\repositories\events;


use booking\entities\events\Provider;

class ProviderRepository
{
    public function get($id): Provider
    {
        if (!$result = Provider::findOne($id))
            throw new \DomainException('Провайдер не найден ID=' . $id);
        return $result;
    }

    public function save(Provider $provider): void
    {
        if (!$provider->save()) {
            throw new \DomainException('Провайдер не сохранен');
        }
    }

    public function remove(Provider $provider): void
    {
        if (!$provider->delete()) {
            throw new \DomainException('Провайдер не удален');
        }
    }
}