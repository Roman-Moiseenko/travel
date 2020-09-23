<?php


namespace office\forms;


use booking\entities\admin\User;
use yii\data\ActiveDataProvider;

class ProvidersSearch extends User
{
    public $id;
    public $username;
    public $email;

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find()->alias('u');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {

            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'u.id' => $this->id,
            'u.status' => $this->status,
        ]);

        $query
            ->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.email', $this->email]);
        return $dataProvider;
    }
}