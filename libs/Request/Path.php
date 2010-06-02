<?php

include_once dirname(__FILE__).'/Abstract.php';

class Awf_Request_Path extends Awf_Request_Abstract {
	
	protected function _getParams(){
 		if(!empty($_SERVER['PATH_INFO']) && $pathInfo = $_SERVER['PATH_INFO']){

//		}elseif($pathInfo = Awf_Request::getRequest()->server()->getParam('ORIG_PATH_INFO')){
			
//		}elseif($pathInfo = Awf_Request::getRequest()->:server()->getParam('QUERY_STRING')){

		}elseif(
			($request_uri = $_SERVER['REQUEST_URI']) && 
			($script_name = $_SERVER['SCRIPT_NAME'])
		){
			$request_uri_a = explode('/',$request_uri);
			foreach(explode('/',$script_name) as $key => $part){				
				if($request_uri_a[$key] != $part){
					break;
				}else{
					unset($request_uri_a[$key]);
				}
			}
			$pathInfo = implode('/',$request_uri_a);
		}
		
		if(!empty($pathInfo)){
			return explode('/', trim($pathInfo, '/'));
		}		
		return array();
	}
	
	/**
	 * Get an assiciative array
	 * @return array
	 */
	public function getAssoc(){
		$vars = $this->getParams();
		$params = array();
		for($i=0;$i<count($vars);$i=$i+2){
			$params[$vars[$i]] = isset($vars[$i+1]) ? $vars[$i+1] : null;
		}
		return $params;		
	}
		
}

