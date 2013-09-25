
<div class="row-fluid">
  <div class="col-lg-4">
  
	<div id="error-div" class="alert alert-dismissable alert-info" style="display:none;"></div>    
       
        <?php if(Yii::app()->user->isGuest):?>
    
        <?php
           $form=$this->beginWidget('CActiveForm', array(
		'id'=>'user_login_form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
                'method' => 'POST',
                'clientOptions'=>array(
                     'validateOnSubmit'=>true,
                     'validateOnChange'=>true,
                     'validateOnType'=>false,
		),
		
		'htmlOptions'=>array('class'=>'well form-horizontal',
				     //'style'=>'background-color:#fff;font-size:14px;font-family:"Open Sans",Arial,Verdana,sans-serif;width:880px;max-width:100%;min-width:304px;'
				     )
	)); ?>
	<fieldset>
        <h3>Sign in to Pridehometutions</h3>
	
	<div id="login-error-div" class="alert" style="display:none;"></div>
		
	<div class="control-group">
	      <label class="control-label" for="UserGroupsUser_usernsme">
		<?php echo CHtml::activeLabelEx($login_model,'username', array('label' => Yii::t('publish_page', 'User Name'),'class'=>'title'));?>
		</label>
	<div class="controls">
	         <?php echo CHtml::activeTextField($login_model,'username',array('maxlength'=>165, 'class' => 'publish_input', 'style' => 'width:176px;', 'tabindex' => 1)); ?>
            </div>
	 </div>
	<div class="control-group">
	      <label class="control-label" for="UserGroupsUser_password">
		<?php echo CHtml::activeLabelEx($login_model,'password', array('label' => Yii::t('publish_page', 'Password'),'class'=>'title'));?>
	      </label>
	      
	<div class="controls">
	         <?php echo CHtml::activePasswordField($login_model,'password',array('maxlength'=>165, 'class' => 'publish_input', 'style' => 'width:176px;', 'tabindex' => 1)); ?>
            </div>
	 </div>
	<div class="control-group">
                <div class="controls">
			<?php echo $form->checkBox($login_model,'rememberMe'); ?>
			<?php echo $form->label($login_model,'rememberMe'); ?>
			<?php echo $form->error($login_model,'rememberMe'); ?>
		</div>
	 </div>
	 
        <div class="form-actions">			
		 <?php $this->widget('bootstrap.widgets.TbButton', array(
                                             'buttonType' => 'ajaxSubmit',
					     'type' =>'custom',
                                            'url' => array('/site/login.GetLogin','type'=>2),
                                            // 'icon' => 'ok', 
                                             'label' => 'Sign In', 
                                              'htmlOptions'=>array("id"=>"login","class" => "btn btn-primary"),
                                             'ajaxOptions' => array(
                                                'beforeSend' => 'function() { 
                            $("#login").attr("disabled",true);
                         
                        }',
                   'complete' => 'function() { 
                       $("#user_login_form").each(function(){
                          this.reset();   
                        });
                            $("#login").attr("disabled",false);
                         
                        }',                                'success'=>'function(data){  
        var obj = jQuery.parseJSON(data); 
       
        if(obj.login == "success"){
	    
            $("#user_login_form").html("<h4>Login Successful! Please Wait...</h4>");
	   
          // setTimeout(function(){location.reload(true);},400);
          parent.location.href = "/dashboard/dash.html";
	 // parent.location.reload(true);
	 
	   
        }else{
            $("#login-error-div").show();
            
            $("#login-error-div").html("Login failed! Try again.");$("#login-error-div").append("<br>");
            $("#login-error-div").append("<a href=\"/user/passRequest.html\">Forgot Password?</a>");
        
        }
    }'),
)); ?>
         </div> <!--form-actions-->    
        </fieldset>
               <?php $this->endWidget();?> 
      <?endif;?>            
                         
  </div>
                      
      <div class="col-lg-4">
<div class="panel panel-success">
              <div class="panel-heading">
                <h3 class="panel-title">Are you a Tutor?</h3>
              </div>
              <div class="panel-body">
            <p> Want to do a part time job in Hyderabad?
Here is a best opportunity to work as a tutor around you.
and earn Rs.4000 to 10000 per/month.</p>

<br>
<?php $this->widget('zii.widgets.jui.CJuiButton',array(
    'buttonType'=>'link',
    'name'=>'btnSubmit',
    'url' =>array('/site/login.GetLogin','type'=>1),
    'value'=>'1',
    'caption'=>'Join Us',
    'htmlOptions'=>array('class'=>'ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover')
    )
); ?>
              </div>
            </div>
</div>
      
      
</div>      