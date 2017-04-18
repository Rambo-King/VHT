<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\AddressBook;

/**
 * AddressBookSearch represents the model behind the search form about `app\models\AddressBook`.
 */
class AddressBookSearch extends AddressBook{

    public $member_email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address_book_id', 'network_id', 'member_id', 'type', 'address_library_id', 'is_default', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['network_name', 'name', 'telephone', 'fixed_line', 'address', 'gate', 'member_email'], 'safe'],
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
        $query = AddressBook::find();
        $query->joinWith(['member']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $attributes = [
            'member_email' => [
                'asc' => ['vht_member.email' => SORT_ASC],
                'desc' => ['vht_member.email' => SORT_DESC],
                'label' => 'Member'
            ],
        ];
        $attributes = array_merge($attributes, $dataProvider->getSort()->attributes);
        $dataProvider->setSort([
            'attributes' => $attributes
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'address_book_id' => $this->address_book_id,
            'network_id' => $this->network_id,
            'member_id' => $this->member_id,
            'type' => $this->type,
            'address_library_id' => $this->address_library_id,
            'is_default' => $this->is_default,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'network_name', $this->network_name])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'fixed_line', $this->fixed_line])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'gate', $this->gate]);
        $query->andFilterWhere(['like', 'vht_member.email', $this->member_email]);

        return $dataProvider;
    }
}
