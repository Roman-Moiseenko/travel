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
            [['id'], 'integer'],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'u.id' => $this->id,
            'u.status' => $this->status,
            //'role'
        ]);

        $query
            ->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.email', $this->email]);
        return $dataProvider;
    }
}