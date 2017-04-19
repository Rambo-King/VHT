<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%unit}}".
 *
 * @property integer $unit_id
 * @property integer $type
 * @property string $name
 * @property integer $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Unit extends ActiveRecord
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
        return '{{%unit}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'name', 'created_by'], 'required'],
            [['description'], 'string'],
            [['type', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'unit_id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Create Date',
            'updated_at' => 'Modify Date',
            'created_by' => 'Creator',
            'updated_by' => 'Modifier',
        ];
    }

    public static function UnitTypeList(){
        return [
            1 => 'Length Unit',
            2 => 'Weight Unit',
        ];
    }

    public static function GetNameByType($type){
        $rows = self::UnitTypeList();
        return $rows[$type];
    }

    public static function UnitList($type = 1){
        $rows = self::find()->where(['type' => $type])->all();
        return ArrayHelper::map($rows, 'unit_id', 'name');
    }

    public static function GetUnitName($id){
        $row = self::find()->where(['unit_id' => $id])->one();
        return $row ? $row->name : null;
    }
}
