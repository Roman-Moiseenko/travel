<?php


namespace booking\repositories\admin\forum;


use booking\entities\admin\forum\Message;
use booking\entities\admin\forum\Post;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

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
            throw new \DomainException('Ошибка сохранения.');
        }
    }

    public function remove(Post $post): void
    {
        if (!$post->delete()) {
            throw new \DomainException('Ошибка удаления.');
        }
    }

    public function getAll($category_id = null): DataProviderInterface
    {
        if ($category_id) {
            $query = Post::find()->andWhere(['category_id' => $category_id]);
        } else{
            $query = Post::find();
        }
        return $this->getProvider($query);
    }

    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['fix' => SORT_DESC, 'update_at' => SORT_DESC],
            ],
            'pagination' => [
                'defaultPageSize' => 20,
                'pageSizeLimit' => [20, 20],
            ],
        ]);
    }

    public function getMessages($post_id): DataProviderInterface
    {
        $query = Message::find()->andWhere(['post_id' => $post_id]);
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort' => SORT_ASC],
            ],
            'pagination' => [
                'defaultPageSize' => 10,
                'pageSizeLimit' => [10, 10],
            ],
        ]);
    }

}