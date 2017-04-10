<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "{{%address_library}}".
 *
 * @property integer $Address_Library_Id
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
            [['ID', 'Elevation'], 'integer'],
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
}
