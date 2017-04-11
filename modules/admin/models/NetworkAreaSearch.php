<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\NetworkArea;

/**
 * NetworkAreaSearch represents the model behind the search form about `app\modules\admin\models\NetworkArea`.
 */
class NetworkAreaSearch extends NetworkArea
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['network_area_id', 'network_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['country', 'code', 'address_string'], 'safe'],
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
        $query = NetworkArea::find();

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
            'network_area_id' => $this->network_area_id,
            'network_id' => $this->network_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'address_string', $this->address_string]);

        return $dataProvider;
    }
}
