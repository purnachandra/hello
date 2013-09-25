
 <?php $this->widget('bootstrap.widgets.TbButton', array(
                                             'type' => 'primary',
                                             'size' => 'large',
                                           //  'url' =>  array('#modal-login'),
                                             'icon' => 'envelope', 
                                             'label' => 'Reply to this Ad', 
                                             // 'htmlOptions'=>array("class" => "btn btn-primary pull-right"),
                                              'htmlOptions'=>array(  
                                                     'data-toggle' => 'modal','data-target'=>'#'.$this->modalId,
                                                     // 'href'=>'',
                                                     'class' => '',
                                                     'onclick' => '$("#contact-modal-body").show();$("#error-div").hide();', 
                                                    )
                                              ));
                                              
  
  ?>


<?php
 $this->beginWidget('bootstrap.widgets.TbModal', array(
                                                       'id'=>$this->modalId,
                                                       'options'=>array('backdrop'=>'static',//'height'=>'auto',
                                                            
                                                               ),
                                                       'events' => array(
                                                'shown'=>'js:(function() {
                                                                  $("#ContactForm_name").focus();})'      
                             // 'show'=>'jQuery(document).unbind('mousedown.dialog-overlay')
                            //.unbind('mouseup.dialog-overlay');',    
                            // 'hide' =>'js:(function(){$("#LoginForm").show();$("#regst_form").hide();})',
                           //  'hidden'=>'js:(function(){$(this).removeData("modal");})'
                                                       ),
                                           'htmlOptions' => array('class'=>'contactmodal'))); 
 ?>
 
<?php
//$this->controller->renderPartial($this->regstViewFile,array('model'=>$model));
$this->controller->renderPartial($this->contactViewFile,array('contact_model'=>$contact_model));
?>
  
<?php  $this->endWidget();?>








