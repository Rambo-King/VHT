<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%network_area}}".
 *
 * @property integer $network_area_id
 * @property integer $network_id
 * @property string $country
 * @property string $code
 * @property string $address_string
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class NetworkArea extends ActiveRecord
{
    public function behaviors(){
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%network_area}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['network_id', 'country', 'code', 'address_string', 'created_at', 'created_by'], 'required'],
            [['network_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['country', 'code'], 'string', 'max' => 32],
            [['address_string'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'network_area_id' => 'ID',
            'network_id' => 'Network ID',
            'country' => 'Country',
            'code' => 'Postcode',
            'address_string' => 'Address String',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
            'created_by' => 'Creator',
            'updated_by' => 'Modifier',
        ];
    }
}
