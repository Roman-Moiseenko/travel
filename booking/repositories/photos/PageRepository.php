<?php
declare(strict_types=1);

namespace booking\repositories\photos;

use booking\entities\photos\Page;

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
}