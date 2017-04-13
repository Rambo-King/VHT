<?php

namespace app\modules\admin\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%network}}".
 *
 * @property integer $network_id
 * @property string $name
 * @property string $description
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class Network extends ActiveRecord
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
        return '{{%network}}';
    }

    public function scenarios(){
        $parentScenarios = parent::scenarios();
        $selfScenarios = [
            'create' => ['name', 'description', 'created_by', 'country', 'region1', 'areas'],
            'update' => ['name', 'description', 'updated_by'],
        ];
        return array_merge($parentScenarios, $selfScenarios);
    }

    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['name', 'country', 'region1', 'areas', 'created_by', 'updated_by'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'network_id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'created_at' => 'Create Date',
            'updated_at' => 'Modify Date',
            'created_by' => 'Creator',
            'updated_by' => 'Modifier',
            'country' => 'Country',
            'region1' => 'Region1',
            'areas' => 'Jurisdiction Areas',
        ];
    }

    public static function NetworkList(){
        $rows = self::find()->all();
        return ArrayHelper::map($rows, 'network_id', 'name');
    }

    public static function GetNameById($id){
        $row = self::find()->where(['network_id' => $id])->one();
        return $row ? $row->name : null;
    }
}
