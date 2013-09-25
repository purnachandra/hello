<?php
 class SimplePager extends CLinkPager{


	const CSS_SELECTED_PAGE='active';
	const CSS_HIDDEN_PAGE = 'disabled';
	public $nextPageLabel = '&gt;'; //' &rarr;';  //
	public $prevPageLabel = '&lt;';  //'&larr;'; //
	public $firstPageLabel = '&lt;&lt;';
	public $lastPageLabel = '&gt;&gt;';
	public $header = '';  //pagination clearfix
	public $footer = '</ul/>';
 
	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;
		echo $this->header;
		echo implode(" ",$buttons);
		echo $this->footer;
	}
	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string the text label for the button
	 * @param integer the page number
	 * @param string the CSS class for the page button. This could be 'page', 'first', 'last', 'next' or 'previous'.
	 * @param boolean whether this page button is visible
	 * @param boolean whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
		$class .= '';
		
		return '<span>'.CHtml::link($label,$this->createPageUrl($this->getController(),$page),array('class'=>$class, 
				)).'</span/>';  
	}
	/**
	 * Creates the URL suitable for pagination.
	 * This method is mainly called by pagers when creating URLs used to
	 * perform pagination. The default implementation is to call
	 * the controller's createUrl method with the page information.
	 * You may override this method if your URL scheme is not the same as
	 * the one supporeted by the controller's createUrl method.
	 * @param CController the controller that will create the actual URL
	 * @param integer the page that the URL should point to. This is a zero-based index.
	 * @return string the created URL
	 */
	public function createPageUrl($controller,$page)
	{        
	        $controller = $this->getController();
                $model_class = ucfirst($controller->getId());
		$route = "";
                $params=$this->getPages()->params===null ? $_GET : $this->params;
                //echo key($params);
		if(empty($route)){
		    $route = key($params);
		    $route = str_replace("_html",".html",$route);  //echo $route;
		}
                if($page>=0) //Here I have made a change.
                        $params[$this->getPages()->pageVar]=$page+1;
                else
			
			unset($params[$this->getPages()->pageVar]);
                reset($params); 
                
                return "/".$route."?".$model_class."_page=".$params[$this->getPages()->pageVar];
	}



}