<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%order_product}}".
 *
 * @property integer $order_product_id
 * @property integer $order_id
 * @property string $order_number
 * @property string $name
 * @property string $description
 * @property integer $quantity
 * @property string $length
 * @property string $width
 * @property string $height
 * @property string $weight
 * @property integer $length_unit_id
 * @property string $length_unit_name
 * @property integer $weight_unit_id
 * @property string $weight_unit_name
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class OrderProduct extends ActiveRecord
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
        return '{{%order_product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'order_number', 'name', 'quantity', 'length', 'width', 'height', 'weight', 'length_unit_id', 'length_unit_name', 'weight_unit_id', 'weight_unit_name'], 'required'],
            [['order_id', 'quantity', 'length_unit_id', 'weight_unit_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['description'], 'string'],
            [['length', 'width', 'height', 'weight'], 'number'],
            [['order_number', 'name', 'length_unit_name', 'weight_unit_name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_product_id' => 'Order Product ID',
            'order_id' => 'Order ID',
            'order_number' => 'Order Number',
            'name' => 'Name',
            'description' => 'Description',
            'quantity' => 'Quantity',
            'length' => 'Length',
            'width' => 'Width',
            'height' => 'Height',
            'weight' => 'Weight',
            'length_unit_id' => 'Length Unit ID',
            'length_unit_name' => 'Length Unit Name',
            'weight_unit_id' => 'Weight Unit ID',
            'weight_unit_name' => 'Weight Unit Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
}
