<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `frontend\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'document'], 'integer'],
            [['name', 'birthday', 'agency', 'registry', 'address', 'complement', 'zip_code', 'neighbourhood', 'city', 'state', 'phone1', 'phone2', 'phone3', 'mail', 'customer_password', 'observation', 'telemarketing'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
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
        $query = Customer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'birthday' => $this->birthday,
            'document' => $this->document,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'agency', $this->agency])
            ->andFilterWhere(['like', 'registry', $this->registry])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'complement', $this->complement])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'neighbourhood', $this->neighbourhood])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'phone1', $this->phone1])
            ->andFilterWhere(['like', 'phone2', $this->phone2])
            ->andFilterWhere(['like', 'phone3', $this->phone3])
            ->andFilterWhere(['like', 'mail', $this->mail])
            ->andFilterWhere(['like', 'customer_password', $this->customer_password])
            ->andFilterWhere(['like', 'observation', $this->observation])
            ->andFilterWhere(['like', 'telemarketing', $this->telemarketing]);

        return $dataProvider;
    }
}
