<?php


namespace booking\repositories\forum;


use booking\entities\forum\Category;
use booking\entities\forum\Message;
use booking\entities\forum\Post;
use yii\data\ActiveDataProvider;
use yii\data\DataProviderInterface;
use yii\db\ActiveQuery;

class PostRepository
{

    public function get($id): Post
    {
        if (!$post = Post::findOne($id)) {
            throw new \DomainException('Данная тема была удалена или не существовала.');
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
        } else {
            $query = Post::find();
        }
        return $this->getProvider($query);
    }

    public function getBySection($section_id): DataProviderInterface
    {
        $query = Post::find()->andWhere([
            'IN',
            'category_id',
            Category::find()->select('id')->andWhere(['section_id' => $section_id])->groupBy('id')
        ])->groupBy('id')->limit(20);

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

    public function getPageByMessage($message_id): int
    {
        $message = Message::findOne($message_id);
        return $this->getPage($message->post_id);
    }

    public function getPage($post_id): int
    {
        $data = $this->getMessages($post_id);
        $data->getModels();
        return $data->getPagination()->getPageCount();
    }

    public function getAllForSitemap()
    {
        return Post::find()->orderBy(['created_at' => SORT_DESC])->all();
    }
}