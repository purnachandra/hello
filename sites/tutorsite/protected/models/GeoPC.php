<?php

class GeoPC extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'GeoPC':
	 * @var string $Country
	 * @var string $Language
	 * @var double $ID
	 * @var string $Region1
	 * @var string $Region2
	 * @var string $Region3
	 * @var string $Region4
	 * @var string $ZIP
	 * @var string $City
	 * @var string $Area1
	 * @var string $Area2
	 * @var double $Lat
	 * @var double $Lng
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'geopc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('Country','length','max'=>2),
			array('Language','length','max'=>2),
			array('Region1','length','max'=>60),
			array('Region2','length','max'=>60),
			array('Region3','length','max'=>60),
			array('Region4','length','max'=>60),
			array('ZIP','length','max'=>10),
			array('City','length','max'=>60),
			array('Area1','length','max'=>80),
			array('Area2','length','max'=>80),
			array('Country, Language, ID, Region1, Region2, Region3, Region4, ZIP, City, Area1, Area2, Lat, Lng', 'required'),
			array('ID, Lat, Lng', 'numerical'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Country' => 'Country',
			'Language' => 'Language',
			'ID' => 'Id',
			'Region1' => 'Region1',
			'Region2' => 'Region2',
			'Region3' => 'Region3',
			'Region4' => 'Region4',
			'ZIP' => 'Zip',
			'City' => 'City',
			'Area1' => 'Area1',
			'Area2' => 'Area2',
			'Lat' => 'Lat',
			'Lng' => 'Lng',
		);
	}
}
