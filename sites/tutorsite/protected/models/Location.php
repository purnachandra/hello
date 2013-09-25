<?php

/**
 * This is the model class for table "location".
 *
 * The followings are the available columns in table 'location':
 * @property integer $location_id
 * @property integer $location_parent_id
 * @property integer $location_active
 * @property string $location_name
 */
class Location extends CActiveRecord
{
	
	public $pincode;
        public $location;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Location the static model class
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
		return 'location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('location_active', 'numerical', 'integerOnly'=>true),
			array('location_name', 'length', 'max'=>255),
			array('location_active, location_name', 'required'),
			array('location_parent_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('location_id, location_parent_id, location_active, location_name', 'safe', 'on'=>'search'),
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
			'location_parent'=>array(self::BELONGS_TO, 'Location', 'location_parent_id'),
			'childs' => array(self::HAS_MANY, 'Location', 'location_parent_id', 'order' => 'location_name ASC'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'location_id' 		=> Yii::t('admin', 'Location'),
			'location_parent_id' => Yii::t('admin_v2', 'Location Parent'),
			'location_active' 	=> Yii::t('admin', 'Location Active'),
			'location_name' 	=> Yii::t('admin', 'Location Name'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('location_id',$this->location_id,true);
		$criteria->compare('location_parent_id',$this->location_parent_id,true);
		$criteria->compare('location_active',$this->location_active);
		$criteria->compare('location_name',$this->location_name,true);
		
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>50,
		    ),
		));
	}
	
	public function getLocationList()
	{
		$ret = array();
		$locations = $this->findAll(array('order' => 'location_name  ASC', 'condition' => 'location_active = 1'));
		if(!empty($locations)){
			foreach ($locations as $k){
				$ret[$k->location_id] = $k->location_name;
			}
		}
		return $ret;
	}
	
	public function getLocationHierarhy( $_level = 0, $_location_parent_id = 0, $_active = 1 )
	{
		$ret = array();
		$_level++;
		
		$criteria = new CDbCriteria();
		if($_location_parent_id){
			$criteria->condition = 't.location_parent_id = ' . $_location_parent_id;
		} else {
			$criteria->condition = 't.location_parent_id IS NULL';
		}
		$criteria->addCondition('t.location_active = ' . (int)$_active);
		$criteria->order = 't.location_name ASC';

		$res = $this->findAll( $criteria );
		if(!empty($res)){
			foreach ($res as $k){
				$childs = $this->getLocationHierarhy( $_level, $k->location_id );
				$ret[] = array('category' 	=> $k, 
							   'childs' 	=> $childs, 
							   'level'		=> $_level);
			}
		}
		return $ret;
	}
	
	public function getLocationHtmlList( &$_container = array(), $_data = array() )
	{
		if(!empty($_data)){
			foreach ($_data as $k){
				$space = '';
				if(isset($k['level']) && $k['level'] != 1){
					$space = str_repeat('&nbsp;' , $k['level']);
				}
				
				$_container[$k['category']->location_id] = $space . $k['category']->location_name;
				if(!empty($k['childs'])){
					$this->getLocationHtmlList( $_container, $k['childs'] );
				}
			}
		}
	}
	
	public function getLocationHtmlListReadyForUse( $_level = 0)
	{
		$ret = array();
		$data = $this->getLocationHierarhy( $_level );
		$this->getLocationHtmlList($ret, $data);
		return $ret;
	}
	
	/**
	 * Suggests a list of existing values matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching lastnames
	 */
	public function suggestOld($keyword,$limit=20)
	{     //echo $keyword; Yii::app()->end();
	    $egeo = new EGeoNameService();$egeo->username = 'caringtutors';
	    $resls = $egeo->postalCodeSearch(array('postalcode'=>$keyword,'country'=>'IN'));
	    //var_dump($resls.length); 
	    $i = 0;
	    while(array_key_exists($i, $resls['postalCodes'])){
	    $resls[$i] = $resls['postalCodes'][$i]['placeName'];$i = $i + 1;
	    }
	   // $suggest[1] = $resls['postalCodes'][1]['placeName'];
	  //  $suggest[2] = $resls['postalCodes'][2]['placeName'];
	    // $suggest[3] = $resls['postalCodes'][3]['placeName'];
	   // foreach($resls as $res)
          //  $res[0] = $resls['postalCodes'][0]['placeName']; echo $res[0];
          //              $res[1] = $resls['postalCodes'][1]['placeName']; echo $res[1];
          //                          $res[2] = $resls['postalCodes'][2]['placeName']; echo $res[2];Yii::app()->end();
	    /*$keyword = "eng";
		$models=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'name',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));*/
		//
		foreach($resls as $i=>$resl){
		
		 $model = new Location;
		 $model->pincode = $keyword;
		 $model->location = $resl;
		 $models[$i] = $model;
		   
		} 
		unset($models["postalCodes"]);     
		foreach($models as $i=>$model) { //$models= CJSON::decode( $loc[$i]['placeName']);print_r($models);//Yii::app()->end();
		  //  var_dump($model->pincode.' - '.$model->location);
		 // var_dump($i);
			$suggest[] = array(
				'label'=>$model->pincode.'-'.$model->location,  // label for dropdown list
				'value'=>$model->pincode,  // value for input field
				'id'=>$model->location,       // return values from autocomplete
				'location'=>$model->location,
				//'call_code'=>$model->call_code,
				
			);
			
		}
		
		// print_r($suggest);Yii::app()->end();
		//$suggest = CJSON::encode($resls);
		return $suggest;
		
                  // return $models;
        }
	/**
	 * Suggests a list of existing values matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of names to be returned
	 * @return array list of matching lastnames
	 */
	public function suggest($keyword,$limit=20){
		   
	    $resls = $this->postalCodeSearch($keyword,$limit);
	    
	    
	    foreach($resls as $i=>$resl){
		
		 $model = new Location;
		 $model->pincode = $resl->ZIP;  //$keyword;
		 $model->location = $resl->City;
		 $models[$i] = $model;
		  
	     } 
		
		foreach($models as $i=>$model) { 
			$suggest[] = array(
				'label'=>is_numeric(substr($keyword, 0, 1)) ? $model->pincode.'-'.$model->location : $model->location,  // label for dropdown list
				'value'=>is_numeric(substr($keyword, 0, 1)) ? $model->pincode : $model->location,  // value for input field
				'id'=>$model->location,       // return values from autocomplete
				'location'=>$model->location,
				//'call_code'=>$model->call_code,
				
			);
			
		}
		
		
		return $suggest;
	
        }
			
	protected function postalCodeSearch($keyword,$limit){
		$fld = is_numeric(substr($keyword, 0, 1)) ? 'ZIP' : 'City';
		
		return GeoPC::model()->findAll(array(
			'condition'=>$fld.' LIKE :keyword',
			'order'=>'City',
			'limit'=>$limit,
			'params'=>array(':keyword'=>"%$keyword%")
		));
	}
	
	
	function isAssoc($arr){
               return array_keys($arr) !== range(0, count($arr) - 1);
        } 
}