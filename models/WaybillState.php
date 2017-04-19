<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%waybill_state}}".
 *
 * @property integer $waybill_state_id
 * @property integer $waybill_id
 * @property string $waybill_number
 * @property integer $state
 * @property string $description
 * @property integer $created_at
 */
class WaybillState extends ActiveRecord
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
        return '{{%waybill_state}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['waybill_id', 'waybill_number', 'state', 'description'], 'required'],
            [['waybill_id', 'state', 'created_at'], 'integer'],
            [['description'], 'string'],
            [['waybill_number'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'waybill_state_id' => 'Waybill State ID',
            'waybill_id' => 'Waybill ID',
            'waybill_number' => 'Waybill Number',
            'state' => 'State',
            'description' => 'Description',
            'created_at' => 'Created At',
        ];
    }
}
