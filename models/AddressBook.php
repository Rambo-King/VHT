<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%address_book}}".
 *
 * @property integer $address_book_id
 * @property integer $network_id
 * @property string $network_name
 * @property integer $member_id
 * @property integer $type
 * @property string $name
 * @property string $telephone
 * @property string $fixed_line
 * @property integer $address_library_id
 * @property string $address
 * @property string $gate
 * @property integer $is_default
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 */
class AddressBook extends ActiveRecord
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
        return '{{%address_book}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['network_id', 'network_name', 'member_id', 'type', 'name', 'telephone', 'address_library_id', 'address'], 'required'],
            [['country', 'region1', 'areas'], 'required'],
            [['network_id', 'member_id', 'type', 'address_library_id', 'is_default', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['network_name', 'name', 'telephone', 'fixed_line', 'gate'], 'string', 'max' => 32],
            [['address'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'address_book_id' => 'ID',
            'network_id' => 'Network ID',
            'network_name' => 'Network',
            'member_id' => 'Member',
            'type' => 'Type',
            'name' => 'Name',
            'telephone' => 'Telephone',
            'fixed_line' => 'Fixed Line',
            'address_library_id' => 'Address Library ID',
            'address' => 'Address',
            'gate' => 'Gate',
            'is_default' => 'Is Default',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
            'created_by' => 'Creator',
            'updated_by' => 'Modifier',
            'country' => 'Country',
            'region1' => 'Region1',
            'areas' => 'Jurisdiction Areas',
        ];
    }

    public static function TypeList(){
        return [
            1 => 'Mailing Address',
            2 => 'Receiving Address',
        ];
    }

    public static function Type($id){
        $types = self::TypeList();
        return $types[$id];
    }

    public function getMember(){
        return $this->hasOne(Member::className(), ['member_id' => 'member_id']);
    }

    public static function BookList($memberId, $type){
        $rows = self::find()->where(['member_id' => $memberId, 'type' => $type])->all();
        $temp = [];
        if($rows){
            foreach($rows as $r){
                $temp[$r->address_book_id] = $r->address.' '.$r->gate;
            }
        }
        return $temp;
    }

}
