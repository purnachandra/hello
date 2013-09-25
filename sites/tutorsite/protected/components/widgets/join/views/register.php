


<?php if (Yii::app()->user->hasFlash('signup')):?>
<div class="info">
    <?php echo Yii::app()->user->getFlash('signup');?>
</div>    
<?php else:?>

<div class="row-fluid">
  <div class="col-lg-5">
    <strong>Why Should I registerwith pridehometutions?</strong>
    <p>
	We are the top choice for Hyderabad parents looking to engage tutors. That is the reason we have a steady stream of eager students/parents requesting for tutors .
Once you register with us and have your profile, location and qualification details with us, it will be easy for us to fulfill the student's requirement.
Register as a tutor with us and prepare for your private home tuition assignment in Hyderabad! 
    </p>
  </div>
  <div class="col-lg-5">	
		<?php
		
		 $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user-groups-registration-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,

                'method' => 'POST',
                'clientOptions'=>array(
                     'validateOnSubmit'=>true,
                     'validateOnChange'=>true,
                     'validateOnType'=>false,
		),
		
		'htmlOptions'=>array('class'=>'well form-horizontal' )
				     //'style'=>'background-color:#7ddfe0;font-size:14px;font-family:"Open Sans",Arial,Verdana,sans-serif;width:880px;max-width:100%;min-width:588px;')
	));
      ?>
      <fieldset>
	<legend>New User Registration</legend>
			
       <div id="signup-error-div" class="alert alert-block alert-error" style="display:none;"></div>
      
    <div class="control-group">
       
	<label class="control-label"><span>I would like to register as a </span><span class="label label-info" data-bind="text: radioSelectedOptionValue" ></span></label>
	<div class="controls"> 
        <div class="column" style="margin-top:6px;">
	    <?php echo CHtml::activeRadioButtonList($model,'group_name', array('Tutor'=>'Tutor','Student'=>'Student'),
			    array( 'labelOptions'=>array('template'=>'<div style="width:67%;float:left;">{input} {label}</div>','separator'=>'  '),'data-bind'=>'checked: radioSelectedOptionValue')); ?>
        </div>
	</div>
	<div style="clear:both;"></div>
    </div>
    
    

    <div class="control-group">
	<label class="control-label" for="UserGroupsUser_usernsme">
		<?php echo CHtml::activeLabelEx($model,'username', array('label' => Yii::t('publish_page', 'User Name')));?>
	</label>
	<div class="controls">
	         <?php echo CHtml::activeTextField($model,'username',array('maxlength'=>255, 'class' => 'publish_input', 'style' => 'width:336px;', 'tabindex' => 1)); ?>
		  <?php echo $form->error($model,'username'); ?>
	</div>	 
    </div>
    <div class="control-group" for="UserGroupsUser_email">
	<label class="control-label" for="UserGroupsUser_email">
		<?php echo CHtml::activeLabelEx($model,'email', array('label' => Yii::t('publish_page', 'Email Id'),'class'=>'title'),array('class'=>''));?>
	</label>
	<div class="controls">
	         <?php echo CHtml::activeTextField($model,'email',array('maxlength'=>255, 'class' => 'publish_input', 'style' => 'width:336px;', 'tabindex' => 1)); ?>
		 <?php echo $form->error($model,'email'); ?>
	</div>	 
    </div>
    <div class="control-group">
	<label class="control-label" for="UserGroupsUser_password">
		<?php echo CHtml::activeLabelEx($model,'password', array('label' => Yii::t('publish_page', 'Password'),'class'=>'title'));?>
		
	</label>
	<div class="controls">
	         <?php echo CHtml::activePasswordField($model,'password',array('maxlength'=>255, 'class' => 'publish_input', 'style' => 'width:336px;', 'tabindex' => 1)); ?>
		 <?php echo $form->error($model,'password'); ?>
	</div>	 
    </div>
    <div class="control-group">
	<label class="control-label" for="UserGroupsUser_password_confirm">
		<?php echo CHtml::activeLabelEx($model,'password_confirm', array('label' => Yii::t('publish_page', 'Repeat Password'),'class'=>'title'));?>
	</label>
	<div class="controls">
	         <?php echo CHtml::activePasswordField($model,'password_confirm',array('maxlength'=>255, 'class' => 'publish_input', 'style' => 'width:336px;', 'tabindex' => 1)); ?>
		 <?php echo $form->error($model,'password_confirm'); ?>
	</div>	 
    </div>
      
           
		<?php
		// additional fields of additional profiles supporting registration
		//foreach ($profiles as $p) {
		//	$this->renderPartial('//'.str_replace(array('{','}'), NULL, $p['model']->tableName()).'/'.$p['view'], array('form' => $form, 'model' => $p['model']));
		//}
		?>
	<?php if (UserGroupsConfiguration::findRule('simple_password_reset') === false): ?>
    <div class="control-group">
	
	<label class="control-label" for="UserGroupsUser_question">
	<?php echo CHtml::activeLabelEx($model,'question', array('label' => Yii::t('publish_page', 'Security Question'),'class'=>'title'));?></label>	
	<div class="controls">	
	         <?php echo CHtml::activeTextField($model,'question',array('maxlength'=>255, 'class' => 'publish_input', 'style' => 'width:336px;', 'tabindex' => 1)); ?>
		 <?php echo $form->error($model,'question'); ?>
	</div>	 
    </div>
    <div class="control-group">
	<label class="control-label" for="UserGroupsUser_answer">
		<?php echo CHtml::activeLabelEx($model,'answer', array('label' => Yii::t('publish_page', 'Answer for Security Question'),'class'=>'title'));?>
	</label>
	<div class="controls">
	         <?php echo CHtml::activeTextField($model,'answer',array('maxlength'=>255, 'class' => 'input-large', 'style' => 'width:336px;', 'tabindex' => 1)); ?>
		 <?php echo $form->error($model,'answer'); ?>
	</div>	 
    </div>
          
    <?php endif; ?>
   
    <div class="row" style="display:none;">
           
	<?php echo $form->textField($model,'facebook',array('value' => $fbUser['id'])); ?>
		<?php //echo $form->error($message,'receiver_id'); ?>
    </div>
    <div class="row" style="display:none;">
	<?php echo $form->hiddenField($model,'firstname',array('value' => $fbUser['first_name'])); ?>
    </div>
    <div class="row" style="display:none;">
	<?php echo $form->hiddenField($model,'lastname',array('value' => $fbUser['last_name'])); ?>
    </div>
    <div class="row" style="display:none;">
	<?php echo $form->hiddenField($model,'displayname',array('value' => $fbUser['name'])); ?>
    </div>
    <div class="row" style="display:none;">
	<?php echo $form->hiddenField($model,'gender',array('value' => $fbUser['gender'])); ?>
    </div>

    <div class="control-group">  
           
            <div class="controls">  
              <label class="checkbox">
		<?php echo $form->checkBox($model, 'terms_ok');?>
               
                I Agree to the terms and conditions
              </label>  
            </div>  
    </div>
    <br>
	
    <div class="actions">
		 <?php $this->widget('bootstrap.widgets.TbButton', array(
                                             'buttonType' => 'ajaxSubmit',
					     'type' =>'custom',
                                            'url' => array('/site/login.GetLogin','type'=>1),
                                            // 'icon' => 'ok', 
                                             'label' => 'Sign Up', 
                                              'htmlOptions'=>array("id"=>"register","class" => "btn btn-success btn-large"),
                                             'ajaxOptions' => array(
                                                'beforeSend' => 'function() { 
                                                   $("#signup-error-div").hide();
                           $("#register").attr("disabled",true);
                         
                        }',
                   'complete' => 'function() { 
                          $("#signup-error-div").show();
                         $("#register").attr("disabled",false);
                         
                        }',
                    'success'=>'function(data){  
                     
                                  var obj = jQuery.parseJSON(data); 
                                  var str = "Please correct the following errors and resubmit the form.\n\n"; //alert(obj);
                                  for (var i=0; i<obj.length; i++) {
                                           var j = i+1;
                                           str = str + j + ".) " + obj[i] + "\n";
                                  }
                                  str = "<pre>"+str+"</pre>";
                                  
                                   $("#signup-error-div").html(str);
                                if(obj.signup == "success"){
	    
                             $("#user-groups-registration-form").html("<p><strong>Signup Successful! </strong></p> <br> ");
			     $("#user-groups-registration-form").append("<p><h5>An email is sent to your registered email account. Please visit your inbox and follow the instructions to activate your account.</h5></p>");
	                     $("#user-groups-registration-form").append("<p>It will take few minutes, please be patient.");
			      $("#user-groups-registration-form").append("<p>Also check your spam folder if you do not receive mail in you inbox</p>");
          // setTimeout(function(){location.reload(true);},400);
        //  parent.location.href = "/site/login.GetLogin";
	 // parent.location.reload(true);
	 //parent.jQuery.fancybox.close();
	   
        }else{
           
        }
    }'),
     )); ?>
     
      <?php   
            echo '<span class="pull-right">';
         echo CHtml::link('Returning User? Sign In',array('/site/login.GetLogin','type'=>2),array('id'=>'user-signin','class' => 'btn btn-info'));
         echo '</span>';?>
	</div>
	
        </fieldset>
       
          
	
	   
	
	   
     <?php $this->endWidget(); ?>
</div>

<?php endif;?>

</div>