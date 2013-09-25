<?php

class Locations extends CActiveRecord
{



	/**
	 * The followings are the available columns in table 'subject':
	 * @var integer $id
	 * @var string $name
	 * @var string $text
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
		return 'locations';
	}

      public function getLocNames(){

            $locations = Locations::model()->findAll(array('order' => 'loc_id'));
            return( CHtml::listData($locations, CHtml::encode('location'), 'location'));

        }
     
}
