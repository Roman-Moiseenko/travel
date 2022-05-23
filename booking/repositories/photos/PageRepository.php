<?php
declare(strict_types=1);

namespace booking\repositories\photos;

use booking\entities\photos\Page;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class PageRepository
{
    public function get($id): Page
    {
        if (!$result = Page::findOne($id)) {
            throw new \DomainException('Фото-Страница не найдена');
        }
        return $result;
    }

    public function save(Page $page): void
    {
        if (!$page->save()) {
            throw new \DomainException('Фото-Страница не сохранена');
        }
    }

    public function remove(Page $page)
    {
        if (!$page->delete()) {
            throw new \DomainException('Ошибка удаления Фото-Страницы');
        }
    }

    public function getAll()
    {
        $query = Page::find()->active()->orderBy(['public_at' => SORT_DESC]);
        return $this->getProvider($query);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => [
                'defaultPageSize' => \Yii::$app->params['paginationPost'],
                'pageSizeLimit' => [\Yii::$app->params['paginationPost'], \Yii::$app->params['paginationPost']],
            ],
        ]);
    }
}