<?php


namespace office\forms\blog;


use booking\entities\blog\Category;
use booking\entities\blog\post\Post;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class PostSearch extends Post
{
    public $date_filter;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'created_at', 'status'], 'integer'],
            [['title'], 'safe'],
            [['date_filter'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Post::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC]
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'category_id' => $this->category_id,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['>=', 'created_at', $this->date_filter ? strtotime($this->date_filter . '00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_filter ? strtotime($this->date_filter . '23:59:59') : null]);
        return $dataProvider;
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->orderBy(['sort' => SORT_ASC])->asArray()->all(),
            'id', 'name');
    }
}