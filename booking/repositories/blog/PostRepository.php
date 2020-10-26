<?php


namespace booking\repositories\blog;


use booking\entities\blog\Category;
use booking\entities\blog\post\Post;
use booking\entities\blog\Tag;
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
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Post $post): void
    {
        if (!$post->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

/** ---------------------------READ------------------ */

    public function count(): int
    {
        return Post::find()->active()->count();
    }

    public function getAllByRange($offset, $limit): array
    {
        return Post::find()->active()->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }

    public function getAll(): DataProviderInterface
    {
        $query = Post::find()->active()->with('category')->orderBy(['public_at' => SORT_DESC]);
        return $this->getProvider($query);
    }

    public function getAllByCategory(Category $category): DataProviderInterface
    {
        $query = Post::find()->active()->andWhere(['category_id' => $category->id])->with('category')->orderBy(['created_at' => SORT_DESC]);
        return $this->getProvider($query);
    }

    public function getAllByTag(Tag $tag): DataProviderInterface
    {
        $query = Post::find()->alias('p')->active('p')->with('category');
        $query->joinWith(['tagAssignments ta'], false);
        $query->andWhere(['ta.tag_id' => $tag->id]);
        $query->groupBy('p.id');
        return $this->getProvider($query);
    }

    public function getLast($limit): array
    {
        return Post::find()->andWhere(['status' => Post::STATUS_ACTIVE])->with('category')->orderBy(['public_at' => SORT_DESC])->limit($limit)->all();
    }

    public function getPopular($limit): array
    {
        return Post::find()->with('category')->orderBy(['comments_count' => SORT_DESC])->limit($limit)->all();
    }

    public function find($id): ?Post
    {
        return Post::find()->active()->andWhere(['id' => $id])->one();
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