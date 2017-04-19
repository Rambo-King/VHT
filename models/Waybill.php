<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%waybill}}".
 *
 * @property integer $waybill_id
 * @property integer $state
 * @property string $waybill_number
 * @property integer $order_id
 * @property string $order_number
 * @property string $agent_number
 * @property integer $created_at
 */
class Waybill extends ActiveRecord
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
        return '{{%waybill}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state', 'waybill_number', 'order_id', 'order_number'], 'required'],
            [['state', 'order_id', 'created_at'], 'integer'],
            [['waybill_number', 'order_number', 'agent_number'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'waybill_id' => 'Waybill ID',
            'state' => 'State',
            'waybill_number' => 'Waybill Number',
            'order_id' => 'Order ID',
            'order_number' => 'Order Number',
            'agent_number' => 'Agent Number',
            'created_at' => 'Created At',
        ];
    }
}
