<?php

class Awf_Template {

	/**
	 * The default options
	 *
	 * @var array
	 */
	protected $options = 	array(
								'template_dir' => 'templates/',
								'extract' => true // Do you want to use $var too next to $this->var
							);

	/**
	 * Store variable
	 *
	 * @var array
	 */
	protected $vars = array();

	protected $assets = array();

	/**
	 * Contructor, set some options
	 *
	 * @param array $options
	 */
	public function __construct($options = array()){
		foreach($this->options as $option_key => $value){
			if(!empty($options[$option_key])){
				$this->options[$option_key] = $options[$option_key];
			}
		}
	}

	/**
	 * Set the params
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function assign($key,$value){
		$this->vars[(string)$key] = $value;
	}

	/**
	 * Fast assiging the variables
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function __set($key,$value){
		$this->assign($key,$value);
	}

	/**
	 * This methods will return one variable
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get_var($key,$default=null){
		$return = $default;
		if(isset($this->vars[(string)$key])){
			$return = $this->vars[(string)$key];
		}
		return $return;
	}

	/**
	 * Return all the variables
	 *
	 * @return array
	 */
	public function get_vars(){
		return $this->vars;
	}

	/**
	 * Quick syntaxis to return just one varible
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function __get($key){
		return $this->get_var($key);
	}

	/**
	 * Check if the variable is set
	 *
	 * @param string $key
	 * @return bool
	 */
	public function __isset($key){
		return isset($this->vars[(string)$key]);
	}

	/**
	 * Unset a variable
	 *
	 * @param string $key
	 */
	public function __unset($key){
		unset($this->vars[(string)$key]);
	}

	/**
	 * This method fetches the template file
	 *
	 * @param string $file
	 * @return string: the parsed file
	 */
	public function fetch($file){
		$file = $this->options['template_dir'].(string)$file;
		if(file_exists($file)){
			ob_start();
			if($this->options['extract']){
				extract($this->vars);
			}
			include $file;
			return ob_get_clean();
		}else{
			throw new Exception('This ('.$file.') template file does not exists');
		}
	}

	/**
	 * This function will echo the parsed template
	 *
	 * @param string $file
	 */
	public function display($file){
		echo $this->fetch($file);
	}

	/**
	 * Register an asset (for example javascript and css files)
	 * @param string $type
	 * @param string $asset
	 */
	public function registerAsset($type,$asset,$overwrite=false){
		if($overwrite || !$this->assetRegistered($asset)) $this->assets[$asset] = array($type,$asset);
	}

	/**
	 * Get all the registered assets
	 * @return array
	 */
	public function getAssets(){
		return $this->assets;
	}

	/**
	 * Check if an asset ia already registered
	 * @param $asset
	 * @return bool
	 */
	public function assetRegistered($asset){
		return array_key_exists($asset,$this->assets);
	}
	
	public function includeTemplate($file){
		$file = $this->options['template_dir'].(string)$file;
		if($this->options['extract']){
			extract($this->vars);
		}
		include $file;
	}

}