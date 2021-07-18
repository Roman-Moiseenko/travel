<?php


namespace booking\repositories\moving;


use booking\entities\moving\Item;

class ItemRepository
{
    public function get($id): Item
    {
        if (!$item = Item::findOne($id)) {
            throw new \DomainException('Элемент не найден.');
        }
        return $item;
    }

    public function save(Item $item): void
    {
        if (!$item->save()) {
            throw new \DomainException('Ошибка сохранения Элемента.');
        }
    }
    public function remove(Item $item): void
    {
        if (!$item->delete()) {
            throw new \DomainException('Ошибка удаления Элемента.');
        }
    }

    public function getMaxSort($page_id)
    {
        return Item::find()->andWhere(['page_id' => $page_id])->max('sort');
    }
}