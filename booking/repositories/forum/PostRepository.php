<?php


namespace booking\repositories\forum;


use booking\entities\forum\Post;

class PostRepository
{

    public function get($id): Post
    {
        if (!$post = Post::findOne($id)) {
            throw new \DomainException('Пост не найден.');
        }
        return $post;
    }

    public function existsByCategory($id): bool
    {
        return Post::find()->andWhere(['category_id' => $id])->exists();
    }

    public function save(Post $post): void
    {
        if (!$post->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Post $post): void
    {
        if (!$post->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}