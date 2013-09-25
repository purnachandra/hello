<?php

/**
 * This is the model class for table "profile".
 *
 * The followings are the available columns in table 'profile':
 * @property integer $id
 * @property string $ug_id
 * @property string $hobbies
 * @property string $avatar
 */
Yii::import('image.models.Image');
Yii::import('image.components.ImgManager');
class Profile extends ManyManyActiveRecord
{
    public $uploadfilename;
    public $tag_search;
    public $tags;   // for training skills
    
    public $category_id;
    
    const STATUS_DRAFT=0;
    const STATUS_PUBLISHED=1;
    const STATUS_ARCHIVED=2;
    public $skill;// =  new Skills;
    public $pcode;public $cat_id; public $scat_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Profile the static model class
	 */
     public static function model($className=__CLASS__){
		return parent::model($className);
     }

     /**
       * @return string the associated database table name
      */
     public function tableName(){
		return '{{profile}}';
     }
     
     public function behaviors(){
        
            return array(
       
                  array(
                      'class'=>'ext.seo.components.SeoRecordBehavior',
                      'route'=>'profile/view',
                      'params'=>array('cv_id'=>$this->cv_id, 'title'=>$this->title),
                    ),
                'image'=>array(
                      'class'=>'image.components.ImgRecordBehavior',
                      'attribute'=>'imageId', // default value
                 ),
		
		 
            );
      }
      
      /**
       * @return array validation rules for model attributes.
       */
      public function rules(){
		
		return array(
			array('ug_id', 'length', 'max'=>20),
			array('title','length','max'=>100),

			array('title, course,contact_name,mobile,degree,expyrs,occupa,location', 'required'),
                   
                        array('title, status,univer,tag_search,tags', 'safe', 'on'=>'search'),
                        array('modified','default', 'value'=>new CDbExpression('NOW()'),
                                                            'setOnEmpty'=>false,'on'=>'update'),
                        array('created,modified','default','value'=>new CDbExpression('NOW()'),
                                                       'setOnEmpty'=>false,'on'=>'insert'),
			
                        array('uploadfilename','safe','on'=>'upload'),
			
			array('cv_id, ug_id',  'safe', 'on'=>'search'),
                        array('addr1,addr2,avatar,  pcode,  imageId, cat_id,contact_name, ug_id,mobile, category, univer, degree','safe'),
                        array('created ,modified','default', 'value'=>new CDbExpression('NOW()'),
                                                            'setOnEmpty'=>false,'on'=>'update'),
                        array('modified','default','value'=>new CDbExpression('NOW()'),
                                                       'setOnEmpty'=>false,'on'=>'insert'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations(){
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                      'skills' => array(self::MANY_MANY, 'Skills', 'cv_skills(cv_id, skill_id)'),
                      'cv_skills' => array(self::HAS_MANY, 'VSkills', 'cv_id'),
                      'owner' => array(self::BELONGS_TO, 'UserGroupsUser', 'ug_id'),
                      'pic' => array(self::HAS_ONE, 'Image', 'ug_id'),
                      
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels(){
		return array(
			'id' => 'ID',
			'ug_id' => 'Ug',
			'id' => 'Id',
			'title' => 'Resume Title',
			'occupa'=>'Presently Working As',
			'course'=>'Highest Qualification',
                        'univer'=>'University',
                        'expyrs'=>'Experience in Yrs.',
                        'contact_name' => 'Contact Name ',
			'degree'=>'Highest Qualifying Degree',
                        'mstatus'=>'Marital Status',
                        'addr1' => 'Address for Communication',
                        'addr2' => 'Nearest Landmark',
			'subject_id'=>'Specialization',
                        'pcode' => 'Place of residence',
                        'location'=>'Location',                         
			'uploadfilename' => 'file name'
		);
	}

	/**
	 * returns an array that contains the views name to be loaded
	 * @return array
	 */
	public function profileViews(){
		return array(
			UserGroupsUser::VIEW => 'index',
			UserGroupsUser::EDIT => 'update',
			
		);
	}

      
         public function getPicture(){
             
           /*  
             $user = $this->owner;
             $pic = $user->relImageLocation;
              if(!empty($pic))
                  return $pic->image_path;
            
              else return '/css/images/no_image.jpg';*/
       }
       
   
             
       public function getLink(){
                $url = '/profile/id/'.$this->cv_id;
              
                return $url;
                
	}
        
        public function getCatUrl($id){

            $cat = Subsubject::model()->findByPk($id);
            return CHtml::link($cat->name,array('cattxt'=>$cat->name,'cat_id'=>$id) );
        
            
        }
        public function getContact(){
            return array('/site/login.GetLogin');
        }

	/**
	 * returns an array that contains the name of the attributes that will
	 * be stored in session
	 * @return array
	 */
	public function profileSessionData(){
		return array(
			'title',
		);
	}
        
       protected function beforeSave(){
                       if(parent::beforeSave()){
                           
                           
			if($this->isNewRecord)
			  $this->created=$this->modified=time();
			else
			   $this->modified=time();
                        
                        if($this->imageId == 0) $this->imageId = 3;
			return true;
		      }
		    else
			return false;
         }
         
      protected function afterSave()
	{
		parent::afterSave(); 
                $uid = Yii::app()->user->id;
            //$folder=Yii::getPathOfAlias('webroot.files.users').DIRECTORY_SEPARATOR;
             $folder=Yii::getPathOfAlias('avatars').DIRECTORY_SEPARATOR;
            if(!is_dir($folder.$uid)) {
                
                mkdir($folder.'/'.$uid,07777,true);
            /*    $il = new Image;
                $il->ug_id = $this->ug_id;
              //  $il->imagename = '/css/images/no_image.jpg';
                if($il->isNewRecord) $il->save(false);*/
            }
                                    
         /*   $avatar = Yii::app()->file->set('files'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR.$this->avatar, true);                      
           if (CFile::set('files/users/'.$this->avatar)->exists)
                   $xlogo = $avatar->move('files'.DIRECTORY_SEPARATOR.'users'.DIRECTORY_SEPARATOR.$this->cv_id.DIRECTORY_SEPARATOR.$this->avatar); 
           */  
                                                 
        }                         
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		
		$criteria=new CDbCriteria;
		$criteria->compare('cv_id',$this->cv_id);
		$criteria->compare('ug_id',$this->ug_id,true);
		$criteria->compare('title',$this->title,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

      
}