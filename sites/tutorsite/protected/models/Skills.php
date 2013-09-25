<?php

/**
 * This is the model class for table "tbl_course".
 *
 * The followings are the available columns in table 'tbl_course':
 * @property string $tag_id
 * @property string $tag_text
 */
class Skills extends CActiveRecord
{
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
		return '{{course}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'length', 'max'=>255),
			array('name', 'required'),
			array('name', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('skill_id, name', 'safe', 'on'=>'search'),
			//array('frequency', 'numerical', 'integerOnly'=>true),
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
                    'profiles' => array(self::MANY_MANY, 'Profile', 'cv_skills(skill_id, cv_id)'),
                    'companies' => array(self::MANY_MANY, 'Profiles', 'cmp_skills(skill_id, cmp_id)'),
                    'cv_skills' => array(self::HAS_MANY, 'VSkills', 'cv_id'),
                    'cmp_skills' => array(self::HAS_MANY, 'CSkills', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'skill_id' 	=> Yii::t('admin','Tag'),
			'name' 	=> Yii::t('admin','Skill Text'),
			'frequency' => Yii::t('admin','Tag Frequency')
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

		$criteria->compare('skill_id',$this->skill_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('frequency',$this->frequency,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
			'pagination'=>array(
		        'pageSize'=>50,
		    ),
		));
	}
	
	/**
	 * Returns tag names and their corresponding weights.
	 * Only the tags with the top weights will be returned.
	 * @param integer the maximum number of tags that should be returned
	 * @return array weights indexed by tag names.
	 */
	public function findTagWeights($limit=20)
	{
		$models=$this->findAll(array(
			'order'=>'frequency DESC',
			'limit'=>$limit,
		));

		$total=0;
		foreach($models as $model)
			$total+=$model->frequency;

		$tags=array();
		if($total>0)
		{
			foreach($models as $model)
				$tags[$model->name]=8+(int)(16*$model->frequency/($total+10));
			ksort($tags);
		}
		return $tags;
	}
        
	/**By me
	 * Suggests a list of existing tags matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching tag names
	 */
	public function suggest($keyword,$limit=20)
	{
		$tags=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'frequency DESC, name',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($tags as $tag)
			$names[]=$tag->name;
		return $names;
	}
	
	/**
	 * Suggests a list of existing tags matching the specified keyword.
	 * @param string the keyword to be matched
	 * @param integer maximum number of tags to be returned
	 * @return array list of matching tag names
	 */
	public function suggestTags($keyword,$limit=20)
	{
		$tags=$this->findAll(array(
			'condition'=>'name LIKE :keyword',
			'order'=>'frequency DESC, tag_text',
			'limit'=>$limit,
			'params'=>array(
				':keyword'=>'%'.strtr($keyword,array('%'=>'\%', '_'=>'\_', '\\'=>'\\\\')).'%',
			),
		));
		$names=array();
		foreach($tags as $tag)
			$names[]=$tag->name;
		return $names;
	}

	
        /*
	public function updateFrequency($oldTags, $newTags)
	{
		$oldTags=self::string2array($oldTags);
		$newTags=self::string2array($newTags);
		$this->addTags(array_values(array_diff($newTags,$oldTags)));
		$this->removeTags(array_values(array_diff($oldTags,$newTags)));
	}*/

	public function addTags( $tags = array() )
	{     $addedIds = array();
		if(!empty($tags)){
			$criteria=new CDbCriteria;
			$criteria->addInCondition('name',$tags);
			$this->updateCounters(array('frequency'=>1),$criteria);
			foreach($tags as $name)
			{      
				if(!$this->exists('name=:name',array(':name'=>$name)) && mb_strlen($name, 'utf-8') >= 4)
				{
					$tag=new Skills;
					$tag->name=$name;
					$tag->frequency=1;
					$tag->save();
					$addedIds[] = $tag->skill_id;
				}
				else{
					$tag = self::model()->findByAttributes(array('name'=>$name));
					$addedIds[] = $tag->skill_id;
				}
			}
		}
		return $addedIds;
	}

	public function removeTags($tags)
	{
		if(empty($tags))
			return;
		$criteria=new CDbCriteria;
		$criteria->addInCondition('name',$tags);
		$this->updateCounters(array('frequency'=>-1),$criteria);
		$this->deleteAll('frequency<=0');
	}
	
	
	 
        public static function getCourseNames($id){

           $criteria = new CDbCriteria;
           $criteria->with = array('cmp_skills');
           $criteria->condition = "t.skill_id in (select skill_id from cmp_skills where id = '{$id}' )";
          $criteria->together = true;
          $skills = Skills::model()->findAll($criteria);
                     $names=array();
		foreach($skills as $tag)
			$names[]=$tag->name;//print_r($names);
		//return self::array2string($names);
		 return $names;
		
        }
}