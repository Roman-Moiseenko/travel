<?php


namespace booking\repositories\moving;


use booking\entities\moving\Item;
use booking\entities\moving\Page;
use booking\helpers\StatusHelper;
use yii\web\NotFoundHttpException;

class PageRepository
{
    public function get($id): Page
    {
        if (!$page = Page::findOne($id)) {
            throw new \DomainException('Страница не найдена.');
        }
        return $page;
    }

    public function save(Page $page): void
    {
        if (!$page->save()) {
            throw new \DomainException('Ошибка сохранения Страницы.');
        }
    }
    public function remove(Page $page): void
    {
        if (!$page->delete()) {
            throw new \DomainException('Ошибка удаления Страницы.');
        }
    }

    public function getAll(): array
    {
        return Page::find()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->andWhere(['>', 'depth', 0])->all();
    }

    public function find($id): ?Page
    {
        return Page::findOne($id);
    }

    public function findBySlug($slug): ?Page
    {
        if (!$page = Page::find()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->andWhere(['slug' => $slug])->andWhere(['>', 'depth', 0])->one()) {
            throw new NotFoundHttpException('Страница не найдена');
        }
        return $page;
    }

    public function findRoot()
    {
        return Page::find()->andWhere(['depth' => 1])->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->all();

    }

    public function getItemsMap($page_id, $item_id): array
    {
        $result = [];
        $items = Item::find()->andWhere(['page_id' => $page_id])->all();
        foreach ($items as $item) {
            if (!$item->isFor($item_id)){
                $result[] = [
                    'id' => $item->id,
                    'title' => $item->title,
                    'photo' => $item->mainPhoto ? $item->mainPhoto->getThumbFileUrl('file', 'map') : '',
                    'address' => $item->address->address,
                    'latitude' => $item->address->latitude,
                    'longitude' => $item->address->longitude
                ];
            }
        }
        return $result;
    }
}