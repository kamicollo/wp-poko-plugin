<?php
/*
Plugin Name: Poko mygtukas
Plugin URI: http://poko.lt
Description: Speciali įskiepio versija Tukučiui!
Version: 1.0-d
Author: Poko komanda
Author URI: http://poko.lt
License: GPL2
*/


require_once(dirname(__FILE__) . '/abstractions.php');
require_once(dirname(__FILE__) . '/buttons.php');
add_action('init', 'PokoButtonPlugin::initialise');


class PokoButtonPlugin {
	
	/* 
	 * Whether to load JS in footer, default = yes. Optimizes page load,
	 * but will not work in some themes. Can be overriden by an option. (#TODO)
	 */
	private static $buttons = array();
	private static $settings = array('twitterHandle' => 'aurimas');
	
	
	public static function initialise() {
		add_action('template_redirect', 'PokoButtonPlugin::initialiseButtonCreation');		
	}
	
	public static function initialiseButtonCreation() {		
		if (is_single()) {
			add_action('wp_enqueue_scripts', 'PokoButtonPlugin::enqueueJS');
			add_action('wp_print_styles', 'PokoButtonPlugin::enqueueCSS');
			add_filter('the_content', 'PokoButtonPlugin::generateButtons');
			add_action('wp_head', 'PokoButtonPlugin::printJS');
			self::$buttons = array(
							new PokoButton(), new TwitterButton(), 
							new PlusOneButton(), new FacebookButton());
		}		
	}
	
	public static function enqueueJS() {
		foreach (self::$buttons as $button) {
			$jsObject = $button->getJS();
			if ($jsObject instanceof jsObject) {
				wp_register_script($jsObject->id, $jsObject->location, $jsObject->dependencies, $jsObject->version, $jsObject->loadInFooter);
				wp_enqueue_script($jsObject->id);
			}
		}
	}
	
	public static function printJS() {
		foreach (self::$buttons as $button) {
			$button->printJS();
		}		
	}
	
	public static function enqueueCSS() {				
		wp_register_style('poko-plugin', plugins_url('poko-plugin.css', __FILE__));
		wp_enqueue_style('poko-plugin');
	}
	
	public static function generateButtons($content = '') {
		$buttons = '';
		foreach(self::$buttons as $button) {
			$buttons .= $button->getHTML();
		}
		return $content . self::wrapButtons($buttons);
	}
	
	protected static function wrapButtons($content) {
		return '<div id="poko-share-collection">' . $content . '</div>';
	}
	
	public static function addScheme($url) {
		if (empty($_SERVER['HTTPS'])) return 'http:/' . $url;
		else return 'https://' . $url;
	}
	
	public static function getSetting($key) {
		return isset(self::$settings[$key]) ? self::$settings[$key] : NULL;
	}
	
}