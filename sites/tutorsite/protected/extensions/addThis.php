<?php
/**
 * addThis widget class file.
 *
 * @author Thiago Otaviani Vidal <thiagovidal@gmail.com>
 * @link http://www.2tov.com
 * @copyright Copyright &copy; 2010 under GPL version 3
 * MADE IN BRAZIL
 */
 
/**
 * addThis extends CWidget and implements a base class for a simple addThis widget.
 * more about addThis can be found on http://www.addthis.com
 * addThis API document can be fount on http://www.addthis.com/help/api-overview
 * @version $Id: 1.0.1
 */

class addThis extends CWidget
{
	// @var string the name of username on addThis.
	public $username; 
	// @var string valid url of addThis script. Defaults to 'http://s7.addthis.com/js/250/addthis_widget.js'.
	public $scriptUrl='http://s7.addthis.com/js/250/addthis_widget.js';
	// @var string valid url of addThis default button. Defaults to 'http://www.addthis.com/bookmark.php?v=250'.
	public $linkUrl='http://www.addthis.com/bookmark.php?v=250';
	// @var string the caption of the addThis default button. Defaults to 'Share'.
	public $defaultButtonCaption='Share';
	// @var boolean whether the default addThis button is visible. Defaults to true.
	public $showDefaultButton=true;
	// @var boolean whether the default addThis button caption is visible. Defaults to true.
	public $showDefaultButtonCaption=true;
	// @var string the separator character. Defaults to '&nbsp;'.
	public $separator='&nbsp;';
	// @var array the addThis div tag attributes.
	public $htmlOptions=array();
	// @var array the addThis default button a tag attributes.
	public $linkOptions=array();
	// @var array the addThis services to show.
	public $showServices=array();
	// @var boolean whether the services name 
	public $showServicesTitle=false;
	// @var array the addThis cofig parameters.
	public $config=array();
	// @var array the addThis share parameters.
	public $share=array();
	
	/**
	 * Run the addThis widget.
	 * This renders the body part of the assThis widget.
	 */
	function run()
	{
		// Run parent CWidget run function.
		parent::run();
		
		// We might not wanna load this while developing since sometimes developer has no internet access, thus the whole page rendering is slowed down big time @ clientside
		/* if(YII_DEBUG) {
			echo CHtml::image('/i/social_developer_fallback.gif', '[SOCIAL BOOKAMRS WIDGET]', array('title'=>'Виджет отключён в девелоперской версии'));
			return;
		} */
		// Get this widget id.
		$id = $this->getId();
		
		// Set this widget id.
		$this->htmlOptions['id']=$id;
		// Set the default 'class' attribute of addThis 'div' otherwise add users custom 'class' attribute.
		empty($this->htmlOptions['class']) ? $this->htmlOptions['class']='addthis_toolbox addthis_default_style' : $this->htmlOptions['class']='addthis_toolbox ' . $this->htmlOptions['class'];
		// Open default addThis div tag with htmlOptions.
		echo CHtml::openTag('div', $this->htmlOptions) . "\n";
		// Open default addThis button if showDefaultButton is set to true.
		if ($this->showDefaultButton)
		{
			// Set the default addThis link url.
			$this->linkOptions['href']=$this->linkUrl;
			// Set the default 'class' attribute of addThis link otherwise set to user defined 'class'.
			empty($this->linkOptions['class']) ? $this->linkOptions['class']='addthis_button_compact' : '';
			// Print default addThis button link tag.
			echo CHtml::openTag('a', $this->linkOptions);
			// Print default addThis button caption if showDefaultButtonCaption is set to true.
				if ($this->showDefaultButtonCaption) 
					echo $this->defaultButtonCaption;
			// Close default addThis button link tag.
			echo CHtml::closeTag('a') . "\n";
		}
		// Check what services to show.
		if(isset($this->showServices)){
			foreach ($this->showServices as $key => $item)
			{
				if(is_array($item)) {
					$serviceCode = $key;
				} else {
					$serviceCode = $item;
				}
				
				$htmlOptions = array_merge( array('class'=>"addthis_button_{$serviceCode}"),
												(is_array($item) ? $item : array()) );
												
				if ($serviceCode != 'separator')
				{
					
					echo CHtml::openTag('a', $htmlOptions);
					if ($this->showServicesTitle && $serviceCode != 'facebook_like')
						echo ucfirst("{$serviceCode}");
					echo CHtml::closeTag('a') . "\n";
				} else {
					echo CHtml::openTag('span',$htmlOptions);
					echo "{$this->separator}";
					echo CHtml::closeTag('span') . "\n";
				}				
			}
			// Destroy @var showServices.
			unset($this->showServices);
		}
		// Close default addThis div tag.
		echo CHtml::closeTag('div');
		echo '<!-- AddThis id:{$this->id}-->';
		// Register script file, addThis config and share if are set.
		$scriptFileUri=isset($this->username)?$scriptFileUri="{$this->scriptUrl}#username={$this->username}" : $scriptFileUri="{$this->scriptUrl}";
		Yii::app()->clientScript->registerScriptFile($scriptFileUri);
		// Check if addThis $config parametes are set if true place them.
		if (!empty($this->config))
		{
			$config = CJavaScript::encode($this->config);
			Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id, "var addthis_config={$config};", false);
		}
		// Destroy addThis #config parameters.
		unset($this->config);
		// Check if addThis $share parametes are set if true place them.
		if (!empty($this->share))
		{
			$share = CJavaScript::encode($this->share);
			Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id, "var addthis_share={$share};", false);
		}
		// Destroy addThis #share parameters.
		unset ($this->share);
	}
}
