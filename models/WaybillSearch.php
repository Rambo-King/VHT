<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Waybill;

/**
 * WaybillSearch represents the model behind the search form about `app\models\Waybill`.
 */
class WaybillSearch extends Waybill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['waybill_id', 'state', 'order_id', 'created_at'], 'integer'],
            [['waybill_number', 'order_number', 'agent_number'], 'safe'],
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
        $query = Waybill::find();

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
            'waybill_id' => $this->waybill_id,
            'state' => $this->state,
            'order_id' => $this->order_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'waybill_number', $this->waybill_number])
            ->andFilterWhere(['like', 'order_number', $this->order_number])
            ->andFilterWhere(['like', 'agent_number', $this->agent_number]);

        return $dataProvider;
    }
}
