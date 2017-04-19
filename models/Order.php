<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $order_id
 * @property string $order_number
 * @property integer $state
 * @property integer $member_id
 * @property integer $network_id
 * @property string $network_name
 * @property integer $mailing_address_id
 * @property string $mailing_address
 * @property integer $receiving_address_id
 * @property string $receiving_address
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Order extends ActiveRecord
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
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_number', 'state', 'member_id', 'network_id', 'network_name', 'mailing_address_id', 'mailing_address', 'receiving_address_id', 'receiving_address'], 'required'],
            [['state', 'member_id', 'network_id', 'mailing_address_id', 'receiving_address_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['order_number', 'network_name'], 'string', 'max' => 32],
            [['mailing_address', 'receiving_address'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_number' => 'Order Number',
            'state' => 'State',
            'member_id' => 'Member ID',
            'network_id' => 'Network ID',
            'network_name' => 'Network Name',
            'mailing_address_id' => 'Mailing Address ID',
            'mailing_address' => 'Mailing Address',
            'receiving_address_id' => 'Receiving Address ID',
            'receiving_address' => 'Receiving Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
