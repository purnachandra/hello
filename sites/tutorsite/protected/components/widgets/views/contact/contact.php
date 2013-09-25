<?php if(Yii::app()->user->hasFlash('contact')): ?>
<div class="alert alert-sucees">
	<h5><?php echo Yii::app()->user->getFlash('contact'); ?></h5>
</div>
<?php else: ?>

<div id="email-sent" class="alert alert-success" style="color:#fff;"><h5>Fill the following form and submit to Contact the Advertiser</h5></div>
<?php

  $form=$this->beginWidget('CActiveForm', array(
		'id'=>'contact-form',
		'enableAjaxValidation'=>false,
		'enableClientValidation'=>true,
                'method' => 'POST',
                'clientOptions'=>array(
                     'validateOnSubmit'=>true,
                     'validateOnChange'=>true,
                     'validateOnType'=>false,
		),
		
		'htmlOptions'=>array('class'=>'form-vertical'
				     //'style'=>'background-color:#7ddfe0;font-size:14px;font-family:"Open Sans",Arial,Verdana,sans-serif;width:315px;max-width:100%;margin-left:8px;padding:6px;'
				     )
	));
  
    ?>
    <div id="contact-error-div" class="alert alert-danger" style="color:#fff;display:none;"> </div>
      <div id="fancy_header" >
	<div class="control-group">
       
	<label class="control-label">
		<?php echo CHtml::activeLabelEx($contact_model,'name', array('label' => Yii::t('publish_page', 'Your Name'),'class'=>'title'));?>
		<span class="tooltipster-icon">(?)</span>
	</label><div class="controls">	
	         <?php echo CHtml::activeTextField($contact_model,'name',array('maxlength'=>255, )); ?>
        </div> </div>
	<div class="control-group">
       
	<label class="control-label">
		<?php echo CHtml::activeLabelEx($contact_model,'email', array('label' => Yii::t('publish_page', 'Your Email'),'class'=>'title'));?>
	</label><div class="controls">	
	         <?php echo CHtml::activeTextField($contact_model,'email',array('maxlength'=>255, )); ?>
        </div> </div>
	<div class="control-group">
       
	<label class="control-label">
		<?php echo CHtml::activeLabelEx($contact_model,'mobile', array('label' => Yii::t('publish_page', 'Your Mobile Number'),'class'=>'title'));?>
	</label><div class="controls">	
	         <?php echo CHtml::activeTextField($contact_model,'mobile',array('maxlength'=>255, )); ?>
        </div> </div>
	<div class="control-group">
       
	<label class="control-label">
		<?php echo CHtml::activeLabelEx($contact_model,'body', array('label' => Yii::t('publish_page', 'Message'),'class'=>'title'));?>
	</label><div class="controls">
	         <?php echo CHtml::activeTextArea($contact_model,'body',array('maxlength'=>255, 'class' => 'publish_input', 'style' => 'width:179px;height:138px;', 'tabindex' => 1)); ?>
        </div> </div>

  <div class="modal-footer">
	    
			 <?php $this->widget('bootstrap.widgets.TbButton', array(
                                             'buttonType' => 'ajaxSubmit',
					     'url'=>array('/site/contact.modal'),
                                             'icon' => 'icon-envelope icon-2x pull-left icon-border', 
                                             'label' => 'Send Message', 
                                              'htmlOptions'=>array("class" => "btn btn-primary pull-left"),
                                             'ajaxOptions' => array(
								  'update'  => '#contact-form', 
                                                                    'success'=>'function(data){
        var obj = $.parseJSON(data);
        if("contact" in obj){
           $("#email-sent").html("<h5>Your Message has been sent to the advertiser. You will receive response shortly!</h5>" );
	    $("#contact-form").hide();
          // setTimeout(function(){location.reload(true);},400);  
        }else{
            $("#contact-error-div").show();
            
            $("#contact-error-div").html("");
            if("ContactForm_name" in obj){
                $("#contact-error-div").html(obj.ContactForm_name[0]+"<br />");
            }
            else if("ContactForm_email" in obj){
                $("#contact-error-div").html(obj.ContactForm_email[0]);
            }
	    else if("ContactForm_mobile" in obj){
                $("#contact-error-div").html(obj.ContactForm_mobile[0]);
            }
            else if("ContactForm_subject" in obj){
                $("#contact-error-div").html(obj.ContactForm_subject[0]);
            }
            else if("ContactForm_body" in obj){
                $("#contact-error-div").html(obj.ContactForm_body[0]+"<br />");
            }
             else if("ContactForm_verifyCode" in obj){
                $("#contact-error-div").html(obj.ContactForm_verifyCode[0]+"<br />");
            }
          $("#contact-modal").show("fast");
         // setTimeout("getRandom();", 10000);//setTimeout(function(){location.reload(true);},400);  
        }
    }'),
)); ?>
		
</div>	
   	
      </div>	    
     <?php $this->endWidget(); ?>

<?php endif; ?>


