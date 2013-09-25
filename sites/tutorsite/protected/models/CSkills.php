<?php

class CSkills extends CActiveRecord
{

   public $id;
   public $job_id;
   public $subject_id;
   public $subsubject_id;

   public $author;
   public $email;

   const STATUS_PENDING=1;
   const STATUS_APPROVED=2;

   //public $text;
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
		return 'cmp_skills';
	}


      public function attributeLabels()
	{
		return array(

		//	'subject_id' => 'Skill',
		//	'subsubject_id' => 'Skill Detail',
	        //         'text'=>'Additional Information',
		);
	}

       public function rules(){
         return array(
           // array('parent,title', 'required'),
	//		array('parent', 'numerical', 'integerOnly'=>true),
	//		array('title', 'length', 'max'=>128),
                  );
       }

        public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		
                     return array(
            'skill'=>array(
                self::BELONGS_TO,
                'Skills',
                'skill_id',
            ),
            'company'=>array(
                self::BELONGS_TO,
                'Profiles',
                'id',
            ),
        );
		
	}
	/**
	 * Returns tag names and their corresponding weights.
	 * Only the tags with the top weights will be returned.
	 * @param integer the maximum number of tags that should be returned
	 * @return array weights indexed by tag names
	 */
/*	public function findSubjWeights($limit=20)
	{
		$criteria=new CDbCriteria(array(
			'select'=>'name, COUNT(job_id) as weight',
			'join'=>'INNER JOIN post_subj ON Subj.id=post_subj.subjId',
			'group'=>'name',
			'having'=>'COUNT(job_id)>0',
			'order'=>'weight DESC',
			'limit'=>20,
		));

		$rows=$this->dbConnection->commandBuilder->createFindCommand($this->tableSchema, $criteria)->queryAll();

		$total=0;
		foreach($rows as $row)
			$total+=$row['weight'];

		$subjs=array();
		if($total>0)
		{
			foreach($rows as $row)
				$subjs[$row['name']]=8+(int)(16*$row['weight']/($total+10));
			ksort($subjs);
		}
		return $subjs;
	}

*/

//       public static function string2array($tags)
//	{
//		return preg_split('/\s*,\s*/',trim($tags),-1,PREG_SPLIT_NO_EMPTY);
//	}


//        public static function array2string($tags)
//	{
//		return implode(', ',$tags);
//	}


       protected function afterSave()

	{     
              // if(isset($_GET['job_id']))
              //    $jobId = $_GET['job_id']; 
            // $this->dbConnection->createCommand("INSERT INTO job_skills (job_id, skill_id,text) VALUES ('{$_GET['id']}','{$this->skill_id}','{$this->text}')")->execute();

       
        }


  public function getSubject()  {

     
    //  $gradeText=Subject::model()->find('id=:gradeID', array(':gradeID'=>$this->subject_id));
    //  return $gradeText->name;
  }

 public function getSubsubject()  {
      
     // $gradeText=Subsubject::model()->find('id=:gradeID', array(':gradeID'=>$this->subsubject_id));
     // return $gradeText->name;
  }


/**
	 * @param Post the post that this comment belongs to. If null, the method
	 * will query for the post.
	 * @return string the permalink URL for this comment
	 */
	public function getUrl($job=null)
	{
		//if($job===null)
		//	$job=$this->job;
		//return $job->url.'#c'.$this->skill_id;
	}
 
/**
	 * @return string the hyperlink display for the current comment's author
	
	public function getAuthorLink()
	{
		if(!empty($this->url))
			return CHtml::link(CHtml::encode($this->author),$this->url);
		else
			return CHtml::encode($this->author);
	} */
}
