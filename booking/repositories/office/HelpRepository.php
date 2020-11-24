<?php


namespace booking\repositories\office;


use booking\entities\admin\Help;

class HelpRepository
{
    public function get($id): Help
    {
        if (!$page = Help::findOne($id)) {
            throw new \DomainException('Страница не найдена.');
        }
        return $page;
    }

    public function save(Help $page): void
    {
        if (!$page->save()) {
            throw new \RuntimeException('Ошибка сохранения Страницы.');
        }
    }
    public function remove(Help $page): void
    {
        if (!$page->delete()) {
            throw new \RuntimeException('Ошибка удаления Страницы.');
        }
    }

    public function getAll(): array
    {
        return Help::find()->andWhere(['>', 'depth', 0])->all();
    }

    public function find($id): ?Help
    {
        return Help::findOne($id);
    }
    public function findById($id): ?Help
    {
        return Help::find()->andWhere(['id' => $id])->andWhere(['>=', 'depth', 0])->one();
    }
    public function findBySlug($slug): ?Help
    {
        return Help::find()->andWhere(['slug' => $slug])->andWhere(['>', 'depth', 0])->one();
    }
}