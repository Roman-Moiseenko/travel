<?php


namespace booking\repositories\realtor;


use booking\entities\realtor\Page;
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
        /*if (!$page = Page::find()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->andWhere(['slug' => $slug])->andWhere(['>', 'depth', 0])->one()) {
            throw new \DomainException('Страница не найдена');
        }*/
        if (!$page = Page::find()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->andWhere(['slug' => $slug])->andWhere(['>', 'depth', 0])->one())
            throw new NotFoundHttpException('');
        return $page;
    }

    public function findRoot(): ?Page
    {
        return Page::find()->andWhere(['depth' => 1])->one();

    }

    public function getAllForSitemap(): array
    {
        return Page::find()->andWhere(['status' => StatusHelper::STATUS_ACTIVE])->andWhere(['>', 'depth', 1])->all();
    }

}