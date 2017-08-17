<?php
namespace PapertrailForWP;
class WPWrapper {

		private static $instance = null;
	  
		public function setInstanceForTest($instance){
			WPWrapper::$instance = $instance;
		}

		public static function getInstance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

		public function sanitize_text_field($value){
		  return	\sanitize_text_field($value);
		}

		public function add_settings_error($value){
		  return	\add_settings_error($value);
		}	
}