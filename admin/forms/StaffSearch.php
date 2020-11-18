<?php


namespace admin\forms;


use booking\entities\check\User;
use yii\data\ActiveDataProvider;

class StaffSearch extends User
{

    public function rules()
    {
        return [
            [['username', 'fullname', 'phone'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find()->andWhere(['admin_id' => \Yii::$app->user->id]);
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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        return $dataProvider;
    }
}