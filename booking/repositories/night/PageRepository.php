<?php


namespace booking\repositories\night;

use booking\entities\night\Page;

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
        return Page::find()->andWhere(['>', 'depth', 0])->all();
    }

    public function find($id): ?Page
    {
        return Page::findOne($id);
    }

    public function findBySlug($slug): ?Page
    {
        return Page::find()->andWhere(['slug' => $slug])->andWhere(['>', 'depth', 0])->one();
    }

    public function findRoot()
    {
        return Page::find()->andWhere(['depth' => 1])->all();

    }

}