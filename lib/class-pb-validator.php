<?php
/**
* This class is used to validate plugin's ajax request parameters.
*
* @category  Library Wordpress Plugins 
* @package   Paper Boot Form
* @author    Denis Nerezov <dnerezov@gmail.com>
* @copyright (c) 2014 Denis Nerezov
* @link      http://bobo.org/license
* @version   1.0.0
* @since     1.0.0
**/
if (!class_exists('PB_Validator')) 
{
	class PB_Validator 
	{
		/*
		* Store validator's instance.
		*
		* @param $instance object
		*/
		private static $instance;
		
		/*
		* Store input error messages.
		*
		* @param $errors array
		*/
		private static $errors   = array();
		
		/*
		* Store input field name.
		*
		* @param $name string
		*/
		private static $name;
		
		/*
		* Store input field value.
		*
		* @param $value mixed
		*/
		private static $value;
		
		/*
		* Instantiate class.
		*
		* @return void
		*/
		public function __construct() {}
		
		/*
		* Get validator's class instance.
		* Enable chaining.
		*
		* @return $instance object
		*/
		public static function instance()
		{
			if (self::$instance === null) {
				self::$instance = new PB_Validator();
			}
			
			return self::$instance;
		}
		
		/*
		* Set input field to validate.
		* Enable chaining.
		*
		* @param $name string
		* @param $name mixed
		* @return $instance object
		*/
		public static function set($name, $value)
		{
			self::$name  = $name;
			self::$value = $value;
			
			return self::$instance;
		}
		
		/*
		* Set input field error message.
		*
		* @param $msg string
		* @return void
		*/
		protected static function addError($msg, $parameters = array())
		{
			//if(is_array($parameters) && count($parameters) > 0) {
				$msg = str_replace(array('min', 'max'), array_values($parameters), $msg);
			//}
			
			self::$errors[self::$name] = $msg;
		}
		
		/*
		* Set "blank" validation rule message.
		* Check whether field value is empty.
		* Enable chaining.
		*
		* @param $msg string
		* @return $instance object
		*/
		public static function blank($msg = 'Cannot be blank')
		{
			if(empty(self::$value)) {
				self::addError($msg);
			}
			
			return self::$instance;
		}
		
		/*
		* Set "range" validation rule message.
		* Check whether number of characters of field's value is within the specified range.
		* Enable chaining.
		*
		* @param $msg string
		* @param $min int
		* @param $max int
		* @return $instance object
		*/
		public static function range($msg = 'Number of characters must be between 3 and 30', $parameters = array('min' => 2, 'max' => 255))
		{
			extract($parameters);
			
			if(!empty(self::$value) && is_string(self::$value)) {
				if(mb_strlen(self::$value) < $min || mb_strlen(self::$value) > $max) {
					self::addError($msg, $parameters);
				}
			}
				
			return self::$instance;
		}
		
		/*
		* Set "alpha" validation rule message.
		* Check whether the characters of field's value is made of alpha characters only.
		* Enable chaining.
		*
		* @param $msg string
		* @param $allowed array
		* @return $instance object
		*/
		public static function alpha($msg = 'Alphabetical characters only', $parameters = array('allowed' => array('.', ',', '-', '_', '@', ' ', '!', '+', '=')))
		{
			extract($parameters);
			
			if(self::$value && !ctype_alpha(str_replace($allowed, '', self::$value))) {
				self::addError($msg);
			}
			
			return self::$instance;
		}
		
		/*
		* Set "alphaNumeric" validation rule message.
		* Check whether the characters of field's value is made of alpha-numeric characters only.
		* Enable chaining.
		*
		* @param $msg string
		* @param $allowed array
		* @return $instance object
		*/
		public static function alphaNumeric($msg = 'Alphabetical and numeric characters only', $parameters = array('allowed' => array('.', ',', '-', '_', '@', ' ', '!', '+', '=')))
		{
			extract($parameters);
			
			if(self::$value && !ctype_alnum(str_replace($allowed, '', self::$value))) {
				self::addError($msg);
			}
			
			return self::$instance;
		}
		
		/*
		* Set "numeric" validation rule message.
		* Check whether the characters of field's value is made of numeric characters only.
		* Enable chaining.
		*
		* @param $msg string
		* @return $instance object
		*/
		public static function numeric($msg = 'Numeric characters only')
		{
			if(self::$value && !is_numeric(self::$value)) {
				self::addError($msg);
			}
			
			return self::$instance;
		}

		/*
		* Set "email" validation rule message.
		* Check whether the format of field's value represents email address.
		* Enable chaining.
		*
		* @param $msg string
		* @return $instance object
		*/
		public static function email($msg = 'Invalid email address')
		{
			if(self::$value && !filter_var(self::$value, FILTER_VALIDATE_EMAIL)) {
				self::addError($msg);
			}
			
			return self::$instance;
		}
		
		/*
		* Set "url" validation rule message.
		* Check whether the format of field's value represents url string.
		* Enable chaining.
		*
		* @param $msg string
		* @return $instance object
		*/
		public static function url($msg = 'Invalid url')
		{
			if(self::$value && !filter_var(self::$value, FILTER_VALIDATE_URL)) {
				self::addError($msg);
			}
			
			return self::$instance;
		}
		
		/*
		* Set "url" validation rule message.
		* Check whether the format of field's value represents url string.
		* Enable chaining.
		*
		* @param $msg string
		* @return $instance object
		*/
		public static function depth($msg = 'Select between 3 and 30', $parameters = array('min' => 1, 'max' => 50))
		{
			extract($parameters);
			
			if(is_array(self::$value) && count(self::$value) < $min || count(self::$value) > $max) {
				self::addError($msg, $parameters);
			}
				
			return self::$instance;
		}
		
		/*
		* Set "custom" validation rule message.
		* Provides gateway for setting up custom validation message.
		* Enable chaining.
		*
		* @param $result bool true/false
		* @param $msg string
		* @return $instance object
		*/
		public static function custom($result, $msg)
		{
			if(!$result) {
				self::addError($msg);
			}
			
			return self::$instance;
		}
		
		/*
		* Get validation status.
		*
		* @return true/false bool
		*/
		public static function status()
		{
			if(count(self::$errors) > 0) {
				return false;
			} else {
				return true;
			}
		}
		
		/*
		* Get validation generated errors.
		*
		* @return $errors array
		*/
		public static function getErrors($name = null)
		{
			if(!empty($name)) {
				if(array_key_exists($name, self::$errors)) {
					return self::$errors[$name];
				}
			} else {
				return self::$errors;
			}
		}
	}
}