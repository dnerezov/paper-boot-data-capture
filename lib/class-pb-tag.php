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
if (!class_exists('PB_Tag'))
{
	class PB_Tag
	{
		/**
		* Render checkbox
		* 
		* @param  $data      
		* @param  $value
		* @param  $checked bool     true/false      
		* @param  $extra
		*
		* @return string    checkbox html tag
		*/
		public static function text($data)
		{
			$data['type'] = 'text';

			return self::input($data);
		}
		
		/**
		* Render checkbox
		* 
		* @param  $data      
		* @param  $value
		* @param  $checked bool     true/false      
		* @param  $extra
		*
		* @return string    checkbox html tag
		*/
		public static function email($data)
		{
			$data['type'] = 'email';

			return self::input($data);
		}
		
		/**
		* Render checkbox
		* 
		* @param  $data      
		* @param  $value
		* @param  $checked bool     true/false      
		* @param  $extra
		*
		* @return string    checkbox html tag
		*/
		public static function url($data)
		{
			$data['type'] = 'url';

			return self::input($data);
		}
		
		/**
		* Render checkbox
		* 
		* @param  $data      
		* @param  $value
		* @param  $checked bool     true/false      
		* @param  $extra
		*
		* @return string    checkbox html tag
		*/
		public static function hidden($data)
		{
			$data['type'] = 'hidden';

			return self::input($data);
		}
		
		/**
		* Render checkbox
		* 
		* @param  $data      
		* @param  $value
		* @param  $checked bool     true/false      
		* @param  $extra
		*
		* @return string    checkbox html tag
		*/
		public static function checkbox($data)
		{
			if(!empty($data['options'])) {
				$optionsSelected = array();
				if(is_array($data['value'])) {
					$optionsSelected = $data['value'];
				}
					
				$output .= '<ul>';
				
				foreach($data['options'] as $name => $value) {
					$output .= '<li>';
					$output .= self::checkbox(array(
						'name'    => $data['name'] . '[]', 
						'id'      => $name, 
						'value'   => $value, 
						'checked' => in_array($name, $optionsSelected))
					);
					$output .= self::label(array(
						'for'   => $name, 
						'value' => $value,
						'style' => 'margin-left: 5px')
					);
					$output .= '</li>';
				}
				
				$output .= '</ul>';
				
				return $output;
			} else {
				if(!empty($data['checked']) && $data['checked'] == true) {
					$checked = true;
				} else {
					$checked = false;
				}
				
				if(!is_array($data)) {
					$data = array('name' => $data);
				}

				$data['type'] = 'checkbox';

				if($checked == true || (isset($data['checked']) && $data['checked'] == true)) {
					$data['checked'] = 'checked';
				} else {
					unset($data['checked']);
				}

				return self::input($data);
			}
		}

		/**
		* Render radio
		* 
		* @param  $data      
		* @param  $value
		* @param  $checked bool     true/false      
		* @param  $extra
		*
		* @return string    radio html tag
		*/
		public static function radio($data)
		{
			if(!empty($data['options'])) {
				$optionsSelected = array();
				if(is_array($data['value'])) {
					$optionsSelected = $data['value'];
				}
			
				$output = '<ul>';
				
				foreach($data['options'] as $name => $value) {
					$output .= '<li>';
					$output .= self::radio(array(
						'name'    => $data['name'], 
						'id'      => $name, 
						'value'   => $value, 
						'checked' => in_array($name, $optionsSelected))
					);
					$output .= self::label(array(
						'for'   => $name, 
						'value' => $value,
						'style' => 'margin-left: 5px')
					);
					$output .= '</li>';
				}
				
				$output .= '</ul>';
				
				return $output;
			} else {
				if(!empty($data['checked']) && $data['checked'] == true) {
					$checked = true;
				} else {
					$checked = false;
				}
				
				if(!is_array($data)) {
					$data = array('name' => $data);
				}

				$data['type'] = 'radio';

				if($checked == true || (isset($data['checked']) && $data['checked'] == true)) {
					$data['checked'] = 'checked';
				} else {
					unset($data['checked']);
				}

				return self::input($data);
			}
		}
		
		/**
		* Render select
		* 
		* @param  $attributes array      
		* @param  $options array
		* @param  $optionsSelected bool 
		*
		* @return string    select html tag
		*/
		public static function select(array $attributes)
		{
			$attributes['delimeter'] = ',';

			if(!empty($attributes['options'])) {
				$options = $attributes['options'];
				if(is_string($options)) {
					$options = explode($attributes['delimeter'], $attributes['options']);
				}
			} else {
				$options = array();
			}
			
			if(array_key_exists('value', $attributes)) {
				$optionsSelected = $attributes['value'];
			}
			
			if(!is_array($optionsSelected)) {
				if(isset($attributes['multiple'])) {
					$optionsSelected = explode($attributes['delimeter'], $optionsSelected);
				} else {
					$optionsSelected = array($optionsSelected);
				}
			}
			
			if(isset($attributes['multiple'])) {
				$attributes['name'] = $attributes['name'] . '[]';
			}
			
			$output = '<select ' . self::attributes($attributes) . '>' . "\n";
			$i = 0;
			foreach($options as $key => $val) {
				//$key = (string) strtolower(trim($val));
				$key = (string) trim($key);
				//$key = (string) $val;


				$selected = null;

				if(in_array($key, $optionsSelected) || in_array($val, $optionsSelected)) {
					$selected = ' selected="selected"';
				}
				
				$output .= '<option value="' . $key . '"' . $selected . '>' . $val . '</option>'."\n";
				$i ++;
			}
			
			unset($attributes['value']);
			
			$output .= '</select>';

			return $output;
		}
		
		/**
		* Render input
		*      
		* @param  $attributes array      
		*
		* @return string    input html tag
		*/
		public static function input($attributes)
		{
			return '<input ' . self::attributes($attributes) . '>';
		}
		
		/**
		* Render textarea
		* 
		* @param  $attributes array      
		*
		* @return string    textarea html tag
		*/
		public static function textarea($attributes)
		{
			$value = $attributes['value'];
			
			unset($attributes['value']);
			return '<textarea ' . self::attributes($attributes) . '>'. $value .'</textarea>';
		}
		
		/**
		* Render label
		* 
		* @param  $attributes array      
		*
		* @return string    label html tag
		*/
		public static function label($attributes)
		{
			$value = $attributes['value'];

			unset($attributes['value']);
			return '<label ' . self::attributes($attributes) . '>'.$value.'</label>';
		}
		
		/**
		* Render label
		* 
		* @param  $attributes array      
		*
		* @return string    label html tag
		*/
		public static function img($attributes)
		{
			return '<img' . self::attributes($attributes) . '/>';
		}
		
		/**
		* Render captcha
		* 
		* @param  $attributes array      
		*
		* @return string    captcha
		*/
		public static function fields($attributes)
		{
			$attributes = $attributes['value'];
			
			include(plugin_dir_path(__FILE__) . '../templates/admin-field.php');
		}
		
		/**
		* Render captcha
		* 
		* @param  $attributes array      
		*
		* @return array  $output
		*/
		private static function attributes(array $attributes = array())
		{
			unset($attributes['options']);
			unset($attributes['delimeter']);
			
			$output = null;
			
			foreach($attributes as $key => $val) {
				if(!is_array($val) || is_object($val)) {
					$output .= ' ' . $key . '="' . htmlspecialchars($val) . '"';
				}
			}

			return $output;
		}
	}
}