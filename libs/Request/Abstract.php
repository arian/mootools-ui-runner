<?php

include_once dirname(__FILE__).'/../Iterator.php';

abstract class Awf_Request_Abstract implements IteratorAggregate {
	
	protected static $_params = false;
	protected $_class_name = null;
	
	/**
	 * Initialize the Request object
	 * @return 
	 */
	public function __construct(){
		$this->_class_name = get_class($this);
		if(!isset(self::$_params[$this->_class_name])){
			self::$_params[$this->_class_name] = $this->_getParams();
		}
	}
	
	/**
	 * Returns an array of the request parameters
	 * @return array
	 */
	protected function _getParams(){
		return array();
	}
	
	/**
	 * 
	 * @return mixed
	 * @param string $key
	 */
	public function getParam($key){
		if(isset(self::$_params[$this->_class_name][$key])){
			return self::$_params[$this->_class_name][$key];
		}else{
			return false;
		}
	}
	
	public function getParams(){
		return self::$_params[$this->_class_name];
	}
	
	/**
	 * Convert the object to an array
	 * @return Returns an external iterator.
	 */
	public function toArray(){
		return (array)self::$_params[$this->_class_name];
	}
	
	/**
	 * Return the object as url string
	 * @return string
	 */
	public function toString(){
		return (string) $this;
	}
	
	/**
	 * Return the object as url string
	 * @return string
	 */
	public function __toString(){
		return implode('/',$this->toArray());
	}

	/**
	 * Retrieve an external iterator
	 * @return 
	 */
    public function getIterator() {
        return new Awf_Iterator($this->toArray());
    }
}

