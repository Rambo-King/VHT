<?php

namespace app\models;

use app\modules\admin\models\NetworkArea;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%address_library}}".
 *
 * @property integer $Address_Library_Id
 * @property integer $Network_Id
 * @property string $ISO
 * @property string $Country
 * @property string $Language
 * @property string $ID
 * @property string $Region1
 * @property string $Region2
 * @property string $Region3
 * @property string $Region4
 * @property string $Locality
 * @property string $Postcode
 * @property string $Suburb
 * @property double $Latitude
 * @property double $Longitude
 * @property integer $Elevation
 * @property string $ISO2
 * @property string $FIPS
 * @property string $NUTS
 * @property string $HASC
 * @property string $STAT
 * @property string $Timezone
 * @property string $UTC
 * @property string $DST
 */
class AddressLibrary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address_library}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ISO', 'Country'], 'required'],
            [['ID', 'Elevation', 'Network_Id'], 'integer'],
            [['Latitude', 'Longitude'], 'number'],
            [['ISO', 'Language'], 'string', 'max' => 2],
            [['Country'], 'string', 'max' => 50],
            [['Region1', 'Region2', 'Region3', 'Region4', 'Locality', 'Suburb'], 'string', 'max' => 80],
            [['Postcode'], 'string', 'max' => 15],
            [['ISO2', 'FIPS', 'UTC', 'DST'], 'string', 'max' => 10],
            [['NUTS', 'HASC'], 'string', 'max' => 12],
            [['STAT'], 'string', 'max' => 20],
            [['Timezone'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Address_Library_Id' => 'Primary',
            'Network_Id' => 'Network',
            'ISO' => 'Iso',
            'Country' => 'Country',
            'Language' => 'Language',
            'ID' => 'ID',
            'Region1' => 'Region1',
            'Region2' => 'Region2',
            'Region3' => 'Region3',
            'Region4' => 'Region4',
            'Locality' => 'Locality',
            'Postcode' => 'Postcode',
            'Suburb' => 'Suburb',
            'Latitude' => 'Latitude',
            'Longitude' => 'Longitude',
            'Elevation' => 'Elevation',
            'ISO2' => 'Iso2',
            'FIPS' => 'Fips',
            'NUTS' => 'Nuts',
            'HASC' => 'Hasc',
            'STAT' => 'Stat',
            'Timezone' => 'Timezone',
            'UTC' => 'Utc',
            'DST' => 'Dst',
        ];
    }

    public static function CountryList(){
        $rows = self::find(['Country'])->groupBy('Country')->all();
        return ArrayHelper::map($rows, 'Country', 'Country');
    }

    public static function Region1List($country){
        $rows = self::find(['Region1'])->where(['Country' => $country])->groupBy('Region1')->all();
        return ArrayHelper::map($rows, 'Region1', 'Region1');
    }

    public static function CodeList($networkId, $addressLibraryId, $country, $region1){
        $records = NetworkArea::GetCodesByNetworkId($networkId);
        $rows = self::find()->where(['Country' => $country, 'Region1' => $region1])->all();
        $temp = [];
        if($rows){
            foreach($rows as $r){
                if($r->Address_Library_Id != $addressLibraryId && in_array($r->Address_Library_Id, $records)) continue;
                $temp[$r->Address_Library_Id] = $r->Region2.' '.$r->Region3.' '.$r->Region4.' '.$r->Locality.' '.$r->Postcode;
            }
        }
        return $temp;
        //return ArrayHelper::map($rows, 'Address_Library_Id', 'Postcode');
    }

    public static function AddressString($id){
        $m = self::find()->where(['Address_Library_Id' => $id])->one();
        return $m->Country.' '.$m->Region1.' '
        .($m->Region2 ? $m->Region2.' ' : null)
        .($m->Region3 ? $m->Region3.' ' : null)
        .($m->Region4 ? $m->Region4.' ' : null)
        .$m->Locality.' '.$m->Postcode;
    }

}
