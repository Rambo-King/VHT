<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AddressLibrary;

/**
 * AddressLibrarySearch represents the model behind the search form about `app\models\AddressLibrary`.
 */
class AddressLibrarySearch extends AddressLibrary
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Address_Library_Id', 'Network_Id', 'ID', 'Elevation'], 'integer'],
            [['ISO', 'Country', 'Language', 'Region1', 'Region2', 'Region3', 'Region4', 'Locality', 'Postcode', 'Suburb', 'ISO2', 'FIPS', 'NUTS', 'HASC', 'STAT', 'Timezone', 'UTC', 'DST'], 'safe'],
            [['Latitude', 'Longitude'], 'number'],
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
        $query = AddressLibrary::find();

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
            'Address_Library_Id' => $this->Address_Library_Id,
            'Network_Id' => $this->Network_Id,
            'ID' => $this->ID,
            'Latitude' => $this->Latitude,
            'Longitude' => $this->Longitude,
            'Elevation' => $this->Elevation,
        ]);

        $query->andFilterWhere(['like', 'ISO', $this->ISO])
            ->andFilterWhere(['like', 'Country', $this->Country])
            ->andFilterWhere(['like', 'Language', $this->Language])
            ->andFilterWhere(['like', 'Region1', $this->Region1])
            ->andFilterWhere(['like', 'Region2', $this->Region2])
            ->andFilterWhere(['like', 'Region3', $this->Region3])
            ->andFilterWhere(['like', 'Region4', $this->Region4])
            ->andFilterWhere(['like', 'Locality', $this->Locality])
            ->andFilterWhere(['like', 'Postcode', $this->Postcode])
            ->andFilterWhere(['like', 'Suburb', $this->Suburb])
            ->andFilterWhere(['like', 'ISO2', $this->ISO2])
            ->andFilterWhere(['like', 'FIPS', $this->FIPS])
            ->andFilterWhere(['like', 'NUTS', $this->NUTS])
            ->andFilterWhere(['like', 'HASC', $this->HASC])
            ->andFilterWhere(['like', 'STAT', $this->STAT])
            ->andFilterWhere(['like', 'Timezone', $this->Timezone])
            ->andFilterWhere(['like', 'UTC', $this->UTC])
            ->andFilterWhere(['like', 'DST', $this->DST]);

        return $dataProvider;
    }
}
