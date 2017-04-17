<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%network_area}}".
 *
 * @property integer $network_area_id
 * @property integer $network_id
 * @property string $network_name
 * @property integer $address_library_id
 * @property string $address
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class NetworkArea extends ActiveRecord
{
    public $country;
    public $region1;
    public $areas;

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
            [['network_id', 'network_name', 'created_by', 'address_library_id'], 'required'],
            [['country', 'region1', 'areas'], 'required'],
            [['network_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['address'], 'string', 'max' => 128],
            [['network_name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'network_area_id' => 'ID',
            'network_id' => 'Network',
            'network_name' => 'Network',
            'address_library_id' => 'Address ID',
            'address' => 'Address',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
            'created_by' => 'Creator',
            'updated_by' => 'Modifier',
            'country' => 'Country',
            'region1' => 'Region1',
            'areas' => 'Jurisdiction Areas',
        ];
    }

    public static function GetCodesByNetworkId($networkId){
        $rows = self::find()->select(['address_library_id'])->where(['network_id' => $networkId])->all();
        $temp = [];
        if($rows){
            foreach($rows as $r){
                $temp[] = $r->address_library_id;
            }
        }
        return $temp;
    }
}
