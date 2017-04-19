<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\OrderProduct;

/**
 * OrderProductSearch represents the model behind the search form about `app\models\OrderProduct`.
 */
class OrderProductSearch extends OrderProduct
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_product_id', 'order_id', 'quantity', 'length_unit_id', 'weight_unit_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['order_number', 'name', 'description', 'length_unit_name', 'weight_unit_name'], 'safe'],
            [['length', 'width', 'height', 'weight'], 'number'],
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
        $query = OrderProduct::find();

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
            'order_product_id' => $this->order_product_id,
            'order_id' => $this->order_id,
            'quantity' => $this->quantity,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'weight' => $this->weight,
            'length_unit_id' => $this->length_unit_id,
            'weight_unit_id' => $this->weight_unit_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'length_unit_name', $this->length_unit_name])
            ->andFilterWhere(['like', 'weight_unit_name', $this->weight_unit_name]);

        return $dataProvider;
    }
}
