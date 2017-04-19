<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%order_state}}".
 *
 * @property integer $order_state_id
 * @property integer $order_id
 * @property string $order_number
 * @property integer $state
 * @property string $description
 * @property integer $created_at
 */
class OrderState extends ActiveRecord
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
        return '{{%order_state}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'order_number', 'state', 'description'], 'required'],
            [['order_id', 'state', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['order_number'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_state_id' => 'Order State ID',
            'order_id' => 'Order ID',
            'order_number' => 'Order Number',
            'state' => 'State',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }
}
