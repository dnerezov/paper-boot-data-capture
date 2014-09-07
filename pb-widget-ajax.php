<?php
/**
* This class is used to provide json response for ajax request.
*
* @category  Library Wordpress Plugins
* @package   Paper Boot Form
* @author    Denis Nerezov <dnerezov@gmail.com>
* @copyright (c) 2014 Denis Nerezov
* @link      http://bobo.org/license
* @version   1.0.0
* @since     1.0.0
**/
if (!class_exists('PB_Widget_Ajax')) 
{
	include_once('pb-form.php');
	
	final class PB_Widget_Ajax extends Paper_Boot_Form
	{
		/*
		* Json string core node name.
		* Usually plugin name is used.
		*
		* @param string
		*/
		private $core_node;
		
		/*
		* Instanciate plugin.
		*
		* @param array $params
		* @return void
		*/
		public function __construct()
		{
			header('Content-type: application/json');

			$this->widget_form_action();
		}
		
		/*
		* Output json string.
		* 
		* @return string json
		*/
		public function __toString()
		{
			$response = array(
				'errors' => PB_Validator::getErrors(),
				'status' => PB_Validator::status()
			);
			
			if(!empty($_POST['prefix'])) {
				$this->core_node = $_POST['prefix'];
			}
			
			$widget_class    = 'Widget_Paperboot_Form_' . $this->core_node;
			$widget_instance = new $widget_class();
			$widget_settings = end(array_values($widget_instance->get_settings()));
			
			if(!empty($widget_settings['submit_event']) && PB_Validator::status()) {
				$response['submit_event'] = html_entity_decode($widget_settings['submit_event']);
			}
			
			return json_encode(array(
				$this->core_node => $response
			));
		}
	}
	
	/*
	* Print response.
	*/
	echo new PB_Widget_Ajax;
}