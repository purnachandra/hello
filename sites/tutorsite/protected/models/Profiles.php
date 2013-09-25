<?php
Yii::import('image.models.Image');
Yii::import('image.components.ImgManager');
class Profiles extends ManyManyActiveRecord
{
    const STATUS_DRAFT=0;
    const STATUS_PUBLISHED=1;
    const STATUS_ARCHIVED=2;
    
   // const IMAGE_EMPTY;
    private $_oldTags;
    
    public $logo_id;
    
    
    public $verifyCode;
    public $url;
    
    public $tags;

    public $image;
    public $lat;
    public $lng;

    public $images;
    
    public $created;
    public $modified;
    public $choose;
    public $saved;    
    public $uploadfilename;
    public $cat_id;
    
    //used for search by chandra
    public $category_id;
    public $scat_id;
	
    public $tskills = Array();
            
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{profiles}}';
	}
        
        public function behaviors(){
        
            return array(
       
                  array(
                      'class'=>'ext.seo.components.SeoRecordBehavior',
                      'route'=>'/profiles/view',
                      'params'=>array('id'=>$this->id, 'title'=>$this->cname),
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
	public function rules()
	{   
	   return array(
		array('addr1,addr2,bizcat','length','max'=>100),
                array('about','length','min'=>150,'max'=>1500,'on'=>'description'),
                array('about','required','on'=>'description'),
                array('mphone,lphone,pcode,location, mphone','length','min'=>1),
                array('url','url') ,
                //array('firstname,lastname','length','max'=>50),
                array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/', 'message'=>'Tags can only contain word characters.'),
	      ///		array('tags', 'normalizeTags'),
                array('cname,location,mphone,addr1', 'required'),
                array('created ,modified','default', 'value'=>new CDbExpression('NOW()'),
                                                            'setOnEmpty'=>false,'on'=>'update'),
                array('modified','default','value'=>new CDbExpression('NOW()'),
                                                       'setOnEmpty'=>false,'on'=>'insert'),
               // array('verifyCode', 'captcha', 'allowEmpty'=>!extension_loaded('gd')),
                array('verifyCode', 'captcha', 'allowEmpty'=>extension_loaded('gd'),'message'=>'Please enter the letters shown in the above image exactly'),
                array('cname, status,location', 'safe', 'on'=>'search'),
                array('cname+location', 'application.extensions.uniqueMultiColumnValidator'),
                array('avatar, pcode, cat_id, category, choose,saved, status, mode, images, imageId,logo_id','safe'),
                array('uploadfilename','safe','on'=>'upload'),

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

                    'owner'=>array(self::HAS_ONE, 'UserGroupsUser', 'ug_id'),
                    'btype'=>array(self::BELONGS_TO, 'BizType', 'type'),
                    'skill'=>array(self::HAS_MANY, 'CSkills','skill_id'),
                    'skills'=>array(self::MANY_MANY, 'Skills','cmp_skills(id, skill_id)'),
                    'pics'=>array(self::HAS_MANY, 'ImageLocation','post_id'),
                    'logo'=>array(self::HAS_ONE, 'Image','ug_id'),
                                     
		); 
	}
         /**
	 * returns an array that contains the views name to be loaded
	 * @return array
	 */
	public function profileViews()
	{
		return array(
			UserGroupsUser::VIEW => 'adpost',
			UserGroupsUser::EDIT => 'update',
			UserGroupsUser::REGISTRATION => 'register'
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'cname' => 'Company Name',
                        'type' =>'Company Type',
                        'lphone'=>'Telephone Landline',
                        'mphone'=>'Telephone Mobile',
                        'pcode'=>'PIN Code',
                        'addr1'=>'Street Address',
                        'addr2'=>'Nearest Land Mark',
                        'bizcat'=>'Business Category',
                        'about'=>'Company Description',
                        'photo'=>'Your Company Logo',
                        'location'=>'Location',
                        'tags'=>'Training Specialization',
                        'cat_id'=>'Category',
                        'mode'=>'Preferred Mode of training',
		);
	} 


        public function getLink()
	{
                /*
                 return CController::createUrl('/profiles/view', array(
			'id'=>$this->id,
			'title'=>$this->cname,
		));
                */
                return $this->getAbsoluteUrl(array('id'=>$this->id,'title'=>$this->cname));
	}
        
       public function getlocUrl()
        {
        return Yii::app()->createUrl('classifieds/profiles/list', array(
            'loc'=>$this->location,
            //'title'=>$this->title,
        ));
        }
        
     /*  public function getLogo(){
           
           if($this->pics){
               $pic = $this->pics[0];
              // return '/files/users/'.$pic->ug_id.'/posts/'.$pic->post_id.'/'.$pic->image_path;
               return $pic->image_path;
           }
         // if($this->photoUrl)
         //    return Yii::app()->params['logosTnPrefix'].$this->photoUrl;
          else return '/css/images/no_image.jpg';
       }*/
      
       public function getLogoTn(){
           
           if($this->pics){
               $pic = $this->pics[0];
              // return '/files/users/'.$pic->ug_id.'/posts/'.$pic->post_id.'/'.$pic->image_path;
               return '/files/posts/'.$pic->post_id.'/thumbnails/tn_'.$pic->image_name;
           }
         // if($this->photoUrl)
         //    return Yii::app()->params['logosTnPrefix'].$this->photoUrl;
          else return '/images/no_image.jpg';
       }
      public function getBizUrl()
        {
        return Yii::app()->createUrl('classifieds/profiles/list', array(
            'type'=>$this->subj->name,
          //  'title'=>$this->title,
        ));
        }
        
        /**
	 * @return array a list of links that point to the post list filtered by every tag of this post
	 */
	public function getTagLinks()
	{
		$links=array();
		foreach(Skills::string2array($this->tags) as $tag)
			$links[]=CHtml::link(CHtml::encode($tag), array('classifieds/profiles/list', 'tag'=>$tag));
		return $links;
	}

        /**
	 * Normalizes the user-entered tags.
	 */
	public function normalizeTags($attribute,$params)
	{
		$this->tags=Skills::array2string(array_unique(Skills::string2array($this->tags)));
	}

	/**
	 * This is invoked after the record is deleted.
	 */
	protected function afterDelete()
	{
		parent::afterDelete();
		//Comment::model()->deleteAll('post_id='.$this->id);
		Skills::model()->updateFrequency($this->subjects, '');
	}

         /**
	 * This is invoked after the record is saved.
	 */
	protected function afterSave()
	{
            
            
            	parent::afterSave();
		Skills::model()->updateFrequency($this->_oldTags, $this->tags);
                
                $folder=Yii::getPathOfAlias('posts').DIRECTORY_SEPARATOR.$this->id;
                     
                if(!is_dir($folder)){
                        mkdir($folder,07777,true);
                        $il = new Image;
                        $il->ug_id = $this->ug_id;
                      //  $il->filename = '/css/images/no_image.jpg';
                        if($il->isNewRecord) $il->save(false);     
                     /*   $il = new ImageLocation();
                        $il->post_id = $this->id;
                        
                        $il->image_path = '/css/images/no_image.jpg';
                        if($il->isNewRecord) $il->save(false);  */    
                 }  
              
                        
                        
                                  
	}

	public function addSkill($skill)
	{
		//if(Yii::app()->params['commentNeedApproval'])
		//	$comment->status=Comment::STATUS_PENDING;
		//else
		$skill->state=Skills::STATUS_APPROVED;
		//$skill->skill_id=$this->job_id;
		return $skill->save();
	}
        
        public function getAddress()
	{
		$addrStr = trim($this->addr1).",".trim($this->addr2).",".
		trim($this->location)." - ".
		trim($this->pcode).","."<abbr title='Phone'>P:</abbr>".$this->lphone." ".$this->mphone;
		$addrArr = explode(",",$addrStr);
                foreach($addrArr as $i=>$line)
			if(empty($line))$addrArr[$i] = false;
			else
			  $addrArr[$i] = $addrArr[$i].",<br>";
                $addrArr = array_filter($addrArr);			
		$address = implode("",$addrArr);
		return $address;		
	}

        protected function beforeSave()
                    {
                       if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
			      $this->created=$this->modified=time();
			      //$this->employer_id=Yii::app()->user->id;
                              $this->cat_id = $this->category;
                              $this->ug_id = Yii::app()->user->id;
			      if(empty($this->imageId)) $this->imageId = 2;
			}
			else
				$this->modified=time();
                        
			return true;
		}
		else
			return false;
                    }

    
         /**
	 * Retrieves the list of posts based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the needed posts.
	 */
       public function searchOld(){
	   
            $criteria=new CDbCriteria;
            $criteria=new CDbCriteria(array(
                 'condition'=>'status='.Profiles::STATUS_PUBLISHED ,
                  'order'=>'modified DESC',
              //    'with'=>'subjs',
                 ));
            $criteria->compare('cname',$this->cname,true);

	    $criteria->compare('location',$this->location,true);

                    
            if(isset($_GET['loc']))
                  $criteria->addSearchCondition('location',$_GET['loc']);
             
            if(isset($_GET['cid'])){
                  $criteria->addSearchCondition('type',$_GET['cid']);
                  $model->type = $_GET['cid'] ;
             }
            if(isset($_GET['tag']))
		  $criteria->addSearchCondition('tags',$_GET['tag']);

	     return new CActiveDataProvider('Profiles', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'status, modified DESC',
			),
		));
	}  
       public function search(){             
                $criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('ug_id',$this->ug_id,true);
		$criteria->compare('cname',$this->cname,true);
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));             
       }
       
    public function doRelativeDate($posted_date) {
    /**
        This function returns either a relative date or a formatted date depending
        on the difference between the current datetime and the datetime passed.
            $posted_date should be in the following format: YYYYMMDDHHMMSS
 
        Relative dates look something like this:
            3 weeks, 4 days ago
        Formatted dates look like this:
            on 02/18/2004
 
        The function includes 'ago' or 'on' and assumes you'll properly add a word
        like 'Posted ' before the function output.
 
        By Garrett Murray, http://graveyard.maniacalrage.net/etc/relative/
    **/
    $in_seconds = strtotime(substr($posted_date,0,8).' '.
                  substr($posted_date,8,2).':'.
                  substr($posted_date,10,2).':'.
                  substr($posted_date,12,2));
    $diff = time()-$in_seconds;
    $months = floor($diff/2592000);
    $diff -= $months*2419200;
    $weeks = floor($diff/604800);
    $diff -= $weeks*604800;
    $days = floor($diff/86400);
    $diff -= $days*86400;
    $hours = floor($diff/3600);
    $diff -= $hours*3600;
    $minutes = floor($diff/60);
    $diff -= $minutes*60;
    $seconds = $diff;
 
    if ($months>0) {
        // over a month old, just show date (mm/dd/yyyy format)
        return 'on '.substr($posted_date,4,2).'/'.substr($posted_date,6,2);//.'/'.substr($posted_date,0,4);
    } else {
        if ($weeks>0) {
            // weeks and days
            $relative_date .= ($relative_date?', ':'').$weeks.' week'.($weeks>1?'s':'');
            $relative_date .= $days>0?($relative_date?', ':'').$days.' day'.($days>1?'s':''):'';
        } elseif ($days>0) {
            // days and hours
            $relative_date .= ($relative_date?', ':'').$days.' day'.($days>1?'s':'');
            $relative_date .= $hours>0?($relative_date?', ':'').$hours.' hour'.($hours>1?'s':''):'';
        } elseif ($hours>0) {
            // hours and minutes
            $relative_date .= ($relative_date?', ':'').$hours.' hour'.($hours>1?'s':'');
            $relative_date .= $minutes>0?($relative_date?', ':'').$minutes.' minute'.($minutes>1?'s':''):'';
        } elseif ($minutes>0) {
            // minutes only
            $relative_date .= ($relative_date?', ':'').$minutes.' minute'.($minutes>1?'s':'');
        } else {
            // seconds only
            $relative_date .= ($relative_date?', ':'').$seconds.' second'.($seconds>1?'s':'');
        }
    }
    // show relative date and add proper verbiage
    return $relative_date.' ago';
  }


}
