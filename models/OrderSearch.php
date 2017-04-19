<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'state', 'member_id', 'network_id', 'mailing_address_id', 'receiving_address_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['order_number', 'network_name', 'mailing_address', 'receiving_address'], 'safe'],
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
        $query = Order::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'state' => $this->state,
            'member_id' => $this->member_id,
            'network_id' => $this->network_id,
            'mailing_address_id' => $this->mailing_address_id,
            'receiving_address_id' => $this->receiving_address_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'network_name', $this->network_name])
            ->andFilterWhere(['like', 'mailing_address', $this->mailing_address])
            ->andFilterWhere(['like', 'receiving_address', $this->receiving_address]);

        return $dataProvider;
    }
}
