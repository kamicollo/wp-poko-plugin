<?php

interface PluggableButton {
	
	public function getJS();
	
	public function getHTML();
	
	public function printJS();
	
}

class JSObject {
	public $id = '';
	public $location = '';
	public $dependencies = array();
	public $version = '';
	public $loadInFooter = true;
	
	public function __construct($params = array()) {
		foreach ($params as $key => $value) {
			$this->{$key} = $value;
		}
	}
}
