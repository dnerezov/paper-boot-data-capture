<?php
/**
* This class is used to initiate Paper Boot Form plugin.
* A Core plugin class that stores all functionalities.
*
* @category  Library Wordpress Plugins
* @package   Paper Boot Form
* @author    Denis Nerezov <dnerezov@gmail.com>
* @copyright (c) 2014 Denis Nerezov
* @link      http://bobo.org/license
* @version   1.0.0
* @since     1.0.0
* 
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
**/
include_once('lib/class-pb-validator.php');
include_once('lib/class-pb-tag.php');

if (!class_exists('Paper_Boot_Form'))
{
	class Paper_Boot_Form
	{
		/*
		* Parent/Base post type name.
		* This post type serves as a store to manage child custom post types.
		* 
		* @param string
		*/
		private $post_type = 'paperboot';
		
		/*
		* Admin main navigation, menu item label.
		* 
		* @param string
		*/
		private $admin_menu_label = 'Paper Boot';
		
		/*
		* Admin grid/edit page title.
		* 
		* @param int
		*/
		private $admin_page_title = 'Paper Boot Form Manager';
		
		/*
		* The part of the page where the edit screen section should be shown.
		* Available options: normal, advanced, side
		*
		* @param string
		*/
		private $admin_meta_box_context = 'normal';
		
		/*
		* Toggle edit page's "bulk actions" toolbar visibility.
		*
		* @param bool
		*/
		private $admin_grid_toolbar_visibility = 'on';
		
		/*
		* Toggle custom post "add post" functionality.
		*
		* @param bool
		*/
		private $admin_create_posts = 'on';
		
		/*
		* Toggle custom post "edit post" functionality.
		*
		* @param bool
		*/
		private $admin_edit_posts = 'on';
		
		/*
		* Store custom post fields.
		*
		* @param array
		*/
		private $fields = array(
			array(
				'mode'          => 'text',
				'input'   => array(
					'params' => array(
						'name'         => 'post_type', 
						'id'           => 'post_type', 
						'class'        => 'form-control', 
						'placeholder'  => 'POST TYPE NAME*', 
						'required'     => 'required',
						'autocomplete' => 'off',					
						'maxlength'    => 30
					)
				),
				'label'             => 'Post Type',
				'description'       => 'Custom post type name',
				'admin_edit'		=> true,
				'admin_grid'		=> true,
				'validation_rules'  => array(
					'range'         => array('min' => 3, 'max' => 1000),
					'alphaNumeric'  => null,
					'blank'         => null
				)
			),
			array(
				'mode'          => 'text',
				'input'   => array(
					'params' => array(
						'name'        => 'admin_menu_label', 
						'id'          => 'admin_menu_label', 
						'class'       => 'form-control', 
						'placeholder' => 'ADMIN MENU TITLE*', 
						'required'    => 'required', 
						'maxlength'   => 30,
						'autocomplete' => 'off'
					)
				),
				'label'             => 'Admin Menu Label',
				'description'       => 'Admin navigation menu item label',
				'admin_edit'		=> true,
				'admin_grid'		=> false,
				'validation_rules'  => array(
					'range'         => array('min' => 3, 'max' => 30),
					'alphaNumeric'  => null,
					'blank'         => null
				)
			),
			array(
				'mode'          => 'input',
				'input'   => array(
					'params' => array(
						'type'        => 'text',
						'name'        => 'admin_page_title', 
						'id'          => 'admin_page_title', 
						'class'       => 'form-control', 
						'placeholder' => 'ADMIN PAGE TITLE*',
						'maxlength'   => 30,
						'autocomplete' => 'off'
					)
				),
				'label'             => 'Admin Page Title',
				'description'       => 'Admin edit page title',
				'admin_edit'		=> true,
				'admin_grid'		=> false,
				'validation_rules'  => array(
					'range'         => array('min' => 3, 'max' => 30),
					'alphaNumeric'  => null,
					'blank'         => null
				)
			),
			array(
				'mode'          => 'select',
				'input'   => array(
					'params'        => array(
						'name'      => 'admin_meta_box_context', 
						'id'        => 'admin_meta_box_context',
						'options'   => array(
							'normal'   => 'Normal', 
							'advanced' => 'Advanced', 
							'side'     => 'Side' 
						)
					)
				),
				'label'             => 'Admin Meta Box Context',
				'description'       => 'The part of the page where the edit screen section should be shown',
				'admin_edit'		=> true,
				'admin_grid'		=> false
			),
			array(
				'mode'          => 'checkbox',
				'input'   => array(
					'params'        => array(
						'name'         => 'admin_grid_toolbar_visibility', 
						'id'           => 'admin_grid_toolbar_visibility',
						'class'        => 'form-control',
						'value'        => 'on',
						'checked'      => true
					)
				),
				'label'             => 'Admin Toolbar Visibility',
				'description'       => 'Whether to display a toolbar (bulk actions and filters) on edit screen',
				'admin_edit'		=> true,
				'admin_grid'		=> true
			),
			array(
				'mode'          => 'checkbox',
				'input'   => array(
					'params'        => array(
						'name'         => 'admin_create_posts', 
						'id'           => 'admin_create_posts',
						'class'        => 'form-control',
						'value'        => 'on',
						'checked'      => true
					)
				),
				'label'             => 'Admin Create Posts',
				'description'       => 'Enable or disable "Add New" post functionality',
				'admin_edit'		=> true,
				'admin_grid'		=> true
			),
			array(
				'mode'          => 'checkbox',
				'input'   => array(
					'params'        => array(
						'name'         => 'admin_edit_posts', 
						'id'           => 'admin_edit_posts',
						'class'        => 'form-control',
						'value'        => 'on',
						'checked'      => true
					)
				),
				'label'             => 'Admin Edit Posts',
				'description'       => 'Toggle custom post edit post functionality',
				'admin_edit'		=> true,
				'admin_grid'		=> true
			),
			array(
				'mode'          => 'fields',
				'input'   => array(
					'params' => array(
						'name'        => 'fields', 
						'id'          => 'fields', 
						'class'       => 'form-control', 
						'placeholder' => 'FORM FIELDS*', 
						'required'    => 'required', 
						'maxlength'   => 10000, 
						'rows'        => 3
					)
				),
				'label'             => 'Fields', 
				'description'       => 'List of form input fields',
				'admin_edit'		=> true,
				'admin_grid'		=> false,
				'validation_rules'  => array(
					'blank'         => null
				)
			)
		);
		
		/*
		* Plugin parameters.
		*
		* @param array
		*/
		private static $post_types = array();
		
		/*
		* Example post
		*
		* @param array
		*/
		public static $post_type_example = array(
			'post_type'                     => 'announcements',
			'post_title'                    => 'Announcements',
			'post_content'                  => null,
			'admin_menu_label'              => 'Announcements',
			'admin_page_title'              => 'Manage Announcements',
			'admin_meta_box_context'        => 'normal',
			'admin_grid_toolbar_visibility' => 'on',
			'admin_create_posts'            => 'on',
			'admin_edit_posts'              => 'on',
			'fields'                        => array(
										array(
											'mode'   => 'input',
											'input'   => array(
												'params' => array(
													'type'  => 'text', 
													'name'  => 'name', 
													'id'    => 'name', 
													'value' => 'Uri Gagarin',
													'class' => 'form-control', 
													'placeholder'  => 'NAME*', 
													'required'     => 'required', 
													'autocomplete' => 'off', 
													'maxlength'    => 30
												)
											),
											'label'             => 'Name',
											'description'       => '',
											'admin_edit'		=> false,
											'admin_grid'		=> true,				
											'validation_rules'  => array(
												'range'         => array('min' => 3, 'max' => 30),
												'alpha'         => null,
												'blank'         => null
											)
										),
										array(
											'mode'   => 'input',
											'input'   => array(
												'params' => array(
													'type'         => 'email', 
													'name'         => 'email', 
													'id'           => 'email',
													'value'        => 'uri.gagarin@domain.com',						
													'class'        => 'form-control', 
													'placeholder'  => 'EMAIL*', 
													'required'     => 'required', 
													'autocomplete' => 'off', 
													'maxlength'    => 30
												)
											),
											'label'             => 'Email',
											'description'       => '',
											'admin_edit'		=> true,
											'admin_grid'		=> true,
											'validation_rules'  => array(
												'range' => array('min' => 3, 'max' => 30),
												'email'         => null,
												'blank'         => null
											)
										),
										array(
											'mode'   => 'input',
											'input'   => array(
												'params' => array(
													'type'         => 'text', 
													'name'         => 'phone', 
													'id'           => 'phone', 
													'value'        => '0123456789',
													'class'        => 'form-control', 
													'placeholder'  => 'PHONE*', 
													'required'     => 'required', 
													'autocomplete' => 'off', 
													'maxlength'    => 12
												)
											),
											'label'            => 'Phone',
											'description'      => '',
											'admin_edit'	   => true,
											'admin_grid'	   => true,
											'validation_rules' => array(
												'range' => array('min' => 6, 'max' => 12),
												'numeric' => null
											)
										),
										array(
											'mode'   => 'input',
											'input'   => array(
												'params' => array(
													'type'         => 'text', 
													'name'         => 'address', 
													'id'           => 'address', 
													'class'        => 'form-control', 
													'placeholder'  => 'ADDRESS', 
													'value'        => '3 Smith St',
													'autocomplete' => 'off', 
													'maxlength'    => 15
												)
											),
											'label'            => 'Address',
											'description'      => '',
											'admin_edit'	   => true,
											'admin_grid'	   => true,
											'validation_rules' => array(
												'range' => array('min' => 3, 'max' => 30),
												'alphaNumeric' => null
											)
										),
										array(
											'mode'   => 'input',
											'input'   => array(
												'params' => array(
													'type'         => 'text', 
													'name'         => 'suburb', 
													'id'           => 'suburb', 
													'class'        => 'form-control', 
													'value'        => 'Some Suburb',
													'placeholder'  => 'SUBURB', 
													'autocomplete' => 'off', 
													'maxlength'    => 30
												)
											),
											'label'            => 'Suburb',
											'description'      => '',
											'admin_edit'	   => true,
											'admin_grid'	   => true,
											'validation_rules' => array(
												'range' => array('min' => 3, 'max' => 30),
												'alpha' => null
											)
										),
										array(
											'mode'   => 'select',
											'input'   => array(
												'params' => array(
													'name'  => 'state', 
													'id'    => 'state', 
													'class' => 'form-control',
													'value' => 'Victoria',
													'multiple' => 'multiple',
													'options' => array(
														''                   => '',
														'NSW'                => 'NSW',
														'Queensland'         => 'Queensland',
														'Victoria'           => 'Victoria',
														'ACT'                => 'ACT',
														'Northern Territory' => 'Northern Territory',
														'South Australia'    => 'South Australia',
														'Tasmania'           => 'Tasmania',
														'Western Australia'  => 'Western Australia'
													)
												)
											),
											'label'             => 'State',
											'description'       => '',
											'admin_grid'		=> true,
											'admin_edit'		=> true,				
											'validation_rules'  => array(
												'blank' => null
											)
										),
										array(
											'mode'   => 'input',
											'input'   => array(
												'params' => array(
													'type'         => 'text', 
													'name'         => 'postcode', 
													'id'           => 'postcode', 
													'value'        => '2025',
													'class'        => 'form-control', 
													'placeholder'  => 'POSTCODE', 
													'autocomplete' => 'off', 
													'maxlength'    => 4
												)
											),
											'label'            => 'Postcode', 
											'description'      => '',
											'admin_edit'	   => true,
											'validation_rules' => array(
												'range' => array('min' => 3, 'max' => 30),
												'numeric' => null
											)
										),
										array(
											'mode'   => 'textarea',
											'input'      => array(
												'params' => array(
													'name'        => 'message', 
													'id'          => 'message', 
													'class'       => 'form-control',
													'value'       => '',						
													'placeholder' => 'MESSAGE*', 
													'required'    => 'required', 
													'maxlength'   => 300, 
													'rows'        => 3,
													'cols'        => 10
												)
											),
											'label'             => 'Message',
											'description'       => '',
											'admin_edit'		=> false,
											'validation_rules'  => array(
												'range'         => array('min' => 3, 'max' => 1000),
												'alphaNumeric'  => null,
												'blank'         => null
											)
										)
									)
		);
		
		/*
		* Instanciate plugin.
		*
		* @param array $params
		* @return void
		*/
		public function __construct(array $posts) 
		{
			$this->set_settings($posts)
				->add_resources();

			add_action('widgets_init',   array(&$this, 'register_widgets'), 1);
			add_action('init',           array(&$this, 'register_post_pype'));
			add_action('admin_head',     array(&$this, 'admin_submenu'));
			add_action('admin_head',     array(&$this, 'admin_grid_toolbar'));
			add_action('admin_head',     array(&$this, 'admin_widget'));
			add_action('add_meta_boxes', array(&$this, 'admin_register_metaboxes'));
			add_action('save_post',      array(&$this, 'admin_metabox_save'), 99, 2);
			add_action('template_redirect', array(&$this, 'register_redirect'));
			add_action('wp_print_scripts', array(&$this, 'auto_save_disable'));			
			add_filter('posts_join',     array(&$this, 'admin_register_meta_search'));
			add_filter('posts_where',    array(&$this, 'admin_register_meta_search_where'));
			
			foreach (self::$post_types as $settings) {
				add_action('manage_' . $settings['post_type'] . '_posts_custom_column',   array(&$this, 'admin_grid_meta_values'), 10, 2);
				add_filter('manage_edit-' . $settings['post_type'] . '_columns',          array(&$this, 'admin_add_grid_columns'));
				add_filter('manage_edit-' . $settings['post_type'] . '_sortable_columns', array(&$this, 'admin_add_grid_columns_sort'));
			}
			
			add_shortcode('paperboot-form', array(&$this, 'set_shortcode_show_form'));
			add_shortcode('paperboot-posts', array(&$this, 'set_shortcode_show_posts'));
			
			$this->set_example_posts();
		}
		
		/*
		* Add and load plugin's external resources.
		*
		* @return object $this
		*/
		private function set_settings(array $posts)
		{
			$posts[] = $this;
			$output  = array();
			
			foreach ($posts as $post) {
				$row = array();
				foreach($post as $key => $value) {
					$row[$key] = $value;
				}
				
				foreach($this as $name => $value) {
					$row[$name] = get_post_meta($post->ID, '_' . $name, true) ? get_post_meta($post->ID, '_' . $name, true) : $post->$name;
				}
				
				$output[] = $row;
			}

			self::$post_types = $output;

			return $this;
		}
		
		/*
		* Add and load plugin's external resources.
		*
		* @return object $this
		*/
		private function add_resources()
		{
			wp_register_script('jQuery.ajax', plugins_url('js/jquery.ajax.js', __FILE__ ));
			wp_register_script('paper-boot-form', plugins_url('js/paper-boot-form.js', __FILE__ ));
			
			wp_enqueue_script('jQuery.ajax', plugins_url('js/jquery.ajax.js', __FILE__ ), false, 1, true);
			wp_enqueue_script('paper-boot-form', plugins_url('js/paper-boot-form.js', __FILE__ ), false, 1, true);

			return $this;
		}
		
		/*
		* Register plugin widget.
		* Stores widget options.
		* Handles front html rendering.
		*
		* @return void
		*/
		public function register_widgets()
		{
			if(!empty(self::$post_types)) {
				foreach (self::$post_types as $settings) {
					$file = __DIR__ . '/pb-widget-form-' . $settings['post_type'] . '.php';
					
					if(!file_exists($file) && !empty($settings['post_type'])) {
						$content = file_get_contents(__DIR__ . '/pb-widget-form.php');
						$words = array(
							'#Widget_Paperboot_Form#' => 'Widget_Paperboot_Form_' . $this->mb_ucfirst($settings['post_type']),
							'#widget_id#'             => 'wpb_widget_pb_form_' . $settings['post_type'],
							'#widget_name#'           => 'PB ' . $this->mb_ucfirst($settings['post_type']),
							'#widget_description#'    => __('Paper Boot ' . $settings['admin_widget_description']),
							'#widget_title#'          => $this->mb_ucfirst($settings['post_type']),
							'#post_type#'             => $settings['post_type'],
							'#widget_from#'           => get_option('admin_email'),
							'#widget_to#'             => get_option('admin_email'),
							'#widget_subject#'        => $this->mb_ucfirst($settings['post_type']) . ' submissions',
							'#post_id#'               => $settings['ID']
						);
						$content = str_replace(array_keys($words), array_values($words), $content);
						file_put_contents($file, $content);
					}

					include_once($file);
					register_widget('Widget_Paperboot_Form_' . $this->mb_ucfirst($settings['post_type']));
				}
			}
		}

		/*
		* Register custom post type.
		*
		* @return void
		*/
		public function register_post_pype() 
		{
			if(self::$post_types) {
				foreach (self::$post_types as $settings) {
					if(!empty($settings['post_type'])) {
						register_post_type($settings['post_type'],
							array(
								'labels' => array(
									'menu_name'          => __($settings['admin_menu_label'], 'text_domain'),
									'name'               => __($settings['admin_page_title'], 'text_domain'),
									'search_items'       => __('Search Contacts', 'text_domain'),
									'not_found'          => __('No records found', 'text_domain'),
									'not_found_in_trash' => __('No records found in Trash', 'text_domain')
								),
								'public'          => true,
								'capability_type' => 'post',
								'capabilities' => array(
									'create_posts' => $settings['admin_create_posts'] != 'on' ? false : true
								),
								'supports'     => $settings['post_type'] == 'paperboot' ? array('title') : false, //, 'thumbnail comments title''excerpt' 'author',
								'menu_position' => $settings['post_type'] == 'paperboot' ? 150 : 20,
								'map_meta_cap' => $settings['admin_edit_posts'] != 'on' ? false : true,
							)
						);
					}
				}
			}
		}
		
		/*
		* Hide custom post's sub menu in admin area.
		* 
		* @return void
		*/
		public function admin_submenu() 
		{
			if(self::$post_types) {
				foreach (self::$post_types as $settings) {
					if($settings['admin_create_posts'] != 'on') {
						echo '<style type="text/css">
						#menu-posts-' . $settings['post_type'] . ' .wp-submenu {
							display: none
						}</style>
						';
					}
				}
			}
		}
		
		/*
		* Provide styles to display widget form validation errors.
		* 
		* @return void
		*/
		public function admin_widget() 
		{
			echo '<style type="text/css">
			.pb-widget-form-validation-error {
				margin-bottom: 10px;
				-moz-border-radius: 3px;
				-webkit-border-radius: 3px 3px 3px 3px;
				border-radius: 3px 3px 3px 3px; 
				border-style: solid; 
				border-width: 1px; 
				padding: 10px; 
				border-color: #CC0000; 
				background-color: #FFEBE8;
				display: block
			}
			
			.alert-danger {
				margin-bottom: 10px;
				-moz-border-radius: 3px;
				-webkit-border-radius: 3px 3px 3px 3px;
				border-radius: 3px 3px 3px 3px; 
				border-style: solid; 
				border-width: 1px; 
				padding: 10px; 
				border-color: #CC0000; 
				background-color: #FFEBE8;
				display: none;
				width: 30%
			}
			
			.alert-danger.active {
				display: block !important;
			}
			
			.edit-meta-fields {
				width: 18%; 
				margin-bottom: 5px;
			}
			
			ul.toolbar-field {
				list-style-type: none;  
				display: inline; 
			}
			
			ul.toolbar-field li {
				display: inline; 
				margin-right: 10px;
				float: right;
				margin-top: 10px;
			}

			.pb-widget-form h5 {
				text-transform: uppercase;
				color: #fff; 
				background-color: #333; 
				padding: 10px; 
				border-bottom: 2px solid #000;
			}
			
			.menu-settings {
				margin: 0;
				border: 0;
			}
			
			#poststuff h2 {
				margin: 0;
				padding: 0
			}
			
			.accord-header {
				cursor: pointer;
				padding-left: 2px;
				padding-right: 5px;
				padding-top: 10px;
				padding-bottom: 10px;
				border-bottom: 1px solid #eee
			}
			/*
			.inlinexX {
					float:left;
					display:inline;
				width: 30%;
				vertical-align: top;
			}
						
			.menu-settings input[type="text"] {
				width: 70%
			}
			
			.paperboot_fields .howto {
				width: 40%
			}
			
			.paperboot_fields .menu-settings dd {
				width: 60%
			}
			
@media (max-width: 480px) {
.inlinexX {
display:block;
width: 100%
}
}*/

			

			
			.accord-content {
				padding-left: 5px;
			}
			
			#paperboot_admin_menu_label, #paperboot_admin_page_title, .paperboot-fields .with-label, .paperboot-fields input.label {
				text-transform: capitalize;
			}
			
			.pb-widget-form .message-save {
				background: none repeat scroll 0 0 #fff;
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.1);
				padding: 1px 12px;
				margin-top: 15px
			}
			
			.pb-widget-form .message-save.message-success {
				border-left: 4px solid #7ad03a;
			}
			
			.pb-widget-form .message-save.message-error {
				border-left: 4px solid #dd3d36;
			}
			
			.text-help {
				color: #999;
			}
			</style>';
		}
		
		/*
		* Hide custom post's bulk actions toolbar.
		* 
		* @return void
		*/
		public function admin_grid_toolbar() 
		{
			$post_type = $this->get_pb_post_type();
			$settings  = $this->get_pb_settings($post_type);
			
			if(!empty($settings) && $settings['admin_grid_toolbar_visibility'] != 'on') {
				echo '<style type="text/css">
					#favorite-actions {
						display:none
					}
					.tablenav{
						display:none
					}
				</style>';
			}

			if(!empty($settings) && $settings['admin_create_posts'] != 'on') {
				echo '<style type="text/css">
					.add-new-h2{
						display:none
					}
				</style>';
			}
		}
		
		/*
		* Add columns to Wordpress admin grid view.
		* Set order of appearance and column abbreviation.
		*
		* @param array $columns
		* @return array
		*/		
		public function admin_add_grid_columns($columns) 
		{
			$output = array();
			
			$post_type = $this->get_pb_post_type();
			$settings  = $this->get_pb_settings($post_type);
			
			$widget_class    = 'Widget_Paperboot_Form_' . $post_type;
			$widget_instance = new $widget_class();
			$widget_settings = end(array_values($widget_instance->get_settings()));
			
			unset($columns['date']);
			
			if(!empty($settings['fields'])) {
				foreach ($settings['fields'] as $field) {
					$name = $this->get_pb_field_name($field);

					if(array_key_exists('admin_grid', $field) && $field['admin_grid'] == 'on') {
						$output[$name] = $field['label'];
					}
					
					if ($name == $widget_settings['post_title_field']) {
						$output['title'] = $name;
						unset($output[$name]);
					}
				}

				if($settings['admin_grid_toolbar_visibility'] != 'on') {
					unset($columns['cb']);
				}
			}
			
			$output['date'] = 'Date';
			
			return array_merge($columns, $output);
		}
		
		/*
		* Enable meta columns sorting in Wordpress admin grid view.
		*
		* @param array $columns
		* @return array
		*/
		public function admin_add_grid_columns_sort($columns)
		{
			$output = array();
			
			$post_type = $this->get_pb_post_type();
			$settings  = $this->get_pb_settings($post_type);
		
			if(!empty($settings['fields'])) {
				foreach ($settings['fields'] as $field) {
					$name = $this->get_pb_field_name($field);
					
					$output[$name] = $name;
				}
			}
			
			return array_merge($output, $columns);
		}
		
		/*
		* Add plugin's meta columns to Wordpress admin grid view.
		*
		* @param string $column
		* @param int $post_id
		* @return void
		*/
		public function admin_grid_meta_values($column, $post_id) 
		{
			if(is_array(get_post_meta($post_id, '_' . $column, true))) {
				if($column == 'fields') {
					echo count(get_post_meta($post_id, '_fields', true));
				} else {
					echo implode(', ', get_post_meta($post_id, '_' . $column, true));
				}
			} else {
				echo get_post_meta($post_id, '_' . $column, true);
			}
		}
		
		/**
		* Register meta boxes.
		* 
		* @param WP_Post $post The object for the current post/page.
		* @return void
		*/
		public function admin_register_metaboxes($post)
		{
			$post_type = $this->get_pb_post_type($post->ID);
			$settings  = $this->get_pb_settings($post_type);
			
			if(!empty($settings['fields'])) {
				foreach ($settings['fields'] as $field) {
					if(array_key_exists('admin_edit', $field) && $field['admin_edit'] != false) {
						$name = $this->get_pb_field_name($field);
						
						add_meta_box(
							$name,
							__($field['label'], 'text_domain'),
							array($this, 'admin_metabox_render'), 
							$settings['post_type'],
							$settings['admin_meta_box_context'],
							'default',
							array(
								'name'  => $name, 
								'field' => $field
							)
						);
					}
				}
			}
		}
		
		/**
		* Render metabox form fields.
		* 
		* @param $post WP_Post The object for the current post/page.
		* @param $metabox Metabox attributes.
		* @return void
		*/
		public function admin_metabox_render($post, $metabox)
		{
			$post_type = $this->get_pb_post_type($post->ID);
			$settings  = $this->get_pb_settings($post_type);

			extract($metabox['args']);

			if($settings) {
				wp_nonce_field('paperboot_form_meta_box', 'paperboot_form_' . $settings['post_type'] . '_nonce');
				
				if($field['admin_edit'] == true) {
					$field['input']['params']['id']    = $settings['post_type'] . '_' . $name;
					$field['input']['params']['name']  = $settings['post_type'] . '_' . $name;
					$field['input']['params']['value'] = get_post_meta($post->ID, '_' . $name, true);
					
					if($field['mode'] == 'checkbox') {
						
						if($field['input']['params']['value'] == 'on') {
							$field['input']['params']['checked'] = true;
						} else {
							$field['input']['params']['checked'] = false;
						}
						
						$field['input']['params']['value'] = 'on';
					}
					?>
					
					<div class="<?php echo $field['input']['params']['id']?>">
						<?php if(!empty($field['description'])) : ?>
						<label class="description" for="<?php echo $field['input']['params']['id']?>" style="margin-bottom: 5px; color: #999; display: block">
							<?php echo $field['description'] ?>
						</label>
						<?php endif ?>
							
						<label class="alert-danger" for="<?php echo $field['input']['params']['id']?>"><?php _e('Cannot be blank', 'text_domain') ?></label>
							
						<?php 
						$mode = $field['mode'];
						echo PB_Tag::$mode($field['input']['params']) ?>
					</div>
					<?php
				}
			}
		}
		
		/**
		* Save meta box input data.
		*
		* @param int $post_id The ID of the post being saved.
		*/
		function admin_metabox_save($post_id, $post)
		{
			$post_type = $this->get_pb_post_type($post_id);
			$settings  = $this->get_pb_settings($post_type);

			if (!isset($_POST['paperboot_form_' . $settings['post_type'] . '_nonce'])) {
				return;
			}
			
			if (!wp_verify_nonce($_POST['paperboot_form_' . $settings['post_type'] . '_nonce'], 'paperboot_form_meta_box')) {
				return;
			}

			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return;
			}

			if (isset($_POST['post_type']) && $settings['post_type'] == $_POST['post_type']) {
				if (!current_user_can('edit_page', $post_id)) {
					return;
				}
			} else {
				if (!current_user_can('edit_post', $post_id)) {
					return;
				}
			}
			
			foreach ($settings['fields'] as $field) {
				$name = $this->get_pb_field_name($field);
				
				if($name == 'fields') {
					// Prevent saving an empty field portion..
					$fields = $_POST['paperboot_fields'];
					
					foreach($fields as $i => $field) {
						if(empty($field['input']['params']['name'])) {
							unset($fields[$i]);
						}
						
						// Prevent saving parameter with empty value
						foreach ($field['input']['params'] as $param_name => $param_value) {
							if(empty($param_value)) {
								unset($fields[$i]['input']['params'][$param_name]);
							}
						}
					}
					
					// Repopulate fields
					$_POST['paperboot_fields'] = $fields;
				}
				
				$value = $_POST[$settings['post_type'] . '_' . $name];
				update_post_meta($post_id, '_' . $name, $value);
			}
		}
		
		/*
		* Restrict access to view custom posts content or listing.
		* Set 404 headers
		* Redirect template to display 404
		* 
		* @return void
		*/
		function register_redirect()
		{
			$post_type = $this->get_pb_post_type();
			$settings  = $this->get_pb_settings($post_type);

			if ($settings) {
				wp_redirect(wp_login_url(), 404);
				include(get_query_template('404'));
				exit;
			}
		}
		
		/*
		* Add custom meta fields to admin search.
		*
		* @param string $join
		* @return string
		*/
		function admin_register_meta_search($join)
		{
			global $pagenow, $wpdb;
		
			$post_type = $this->get_pb_post_type();
			$settings  = $this->get_pb_settings($post_type);
			
			if (is_admin() && $pagenow == 'edit.php' && $settings && $_GET['s'] != '') {    
				$join .= 'LEFT JOIN ' . $wpdb->postmeta . ' ON ' . $wpdb->posts . ' . ID = ' . $wpdb->postmeta . '.post_id ';
			}
			
			return $join;
		}
		
		/*
		* Add custom meta fields to admin search.
		*
		* @param string $join
		* @return string
		*/
		public function admin_register_meta_search_where($where) 
		{
			global $pagenow, $wpdb;
			
			$post_type = $this->get_pb_post_type();
			$settings  = $this->get_pb_settings($post_type);
			
			if (is_admin() && $pagenow == 'edit.php' && $settings && $_GET['s'] != '') {
				$where = preg_replace(
			   "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			   "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
			}
			
			return $where;
		}
		
		/*
		* Handle front form submission process.
		*
		* @return void
		*/
		protected function widget_form_action()
		{
			// Include Wordpress framework
			$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
			require_once($parse_uri[0] . 'wp-load.php');
			
			$post_type = $this->get_pb_post_type();
			$settings  = $this->get_pb_settings($post_type);

			if($settings && !empty($_POST)) {
				// Get widget settings
				$widget_class    = 'Widget_Paperboot_Form_' . $post_type;
				$widget_instance = new $widget_class();
				$widget_settings = end(array_values($widget_instance->get_settings()));
				
				// Instanciate validation
				$validation = PB_Validator::instance();
				
				foreach ($settings['fields'] as $field) {
					$name = $this->get_pb_field_name($field);
					
					if(array_key_exists('validation_rules', $field)) {
						$validation->set($name, $_POST[$name]);
						
						foreach ($field['validation_rules'] as $rule_name => $rule_params) {
							if(!empty($rule_params) && is_array($rule_params)) {
								// Set validation rule with parameters
								$validation->$rule_name($widget_settings['messages'][$rule_name], $rule_params);
							} else {
								// Set validation rule without parameters
								$validation->$rule_name($widget_settings['messages'][$rule_name]);
							}
						}
					}
				}
				
				// Set and run captcha validation
				if ($widget_settings['show_captcha'] && array_key_exists('captcha', $_POST)) {
					$validation->set('captcha', $_POST ? $_POST['captcha'] : null)
						->custom(self::captcha(), $widget_settings['messages']['captcha'])
						->blank();
				}
				
				// Set post title
				$post_title_field = null;
				if (!empty($widget_settings['post_title_field']) && array_key_exists($widget_settings['post_title_field'], $_POST)) {
					$post_title_field = sanitize_text_field($_POST[$widget_settings['post_title_field']]);
				}
				
				// Execute when no validation error
				if ($validation::status() == true) {
					
					// Insert post
					$post_id = wp_insert_post(array(
						'post_type'    => $settings['post_type'],
						'post_content' => null, 
						'post_title'   => $post_title_field, //is_string($_POST[key($_POST)]) ? sanitize_text_field($_POST[key($_POST)]) : null,
						'post_status'  => 'publish'
					));
					
					// Save meta data
					foreach ($settings['fields'] as $field) {
						$name = $this->get_pb_field_name($field);
						if(array_key_exists($name, $_POST)) {
							update_post_meta($post_id, '_' . $name, $_POST[$name]);
						}
					}
					
					// Get widget options
					$widget_class     = 'Widget_Paperboot_Form_' . $this->mb_ucfirst($settings['post_type']);
					$widget_instance  = new $widget_class;
					$widget_settings  = end(array_values($widget_instance->get_settings()));
					$email            = $widget_settings['email'];
					
					// Prepare notification email
					$email['notification']['headers'] = implode("\r\n", array(
												'MIME-Version: 1.0', 
												'Content-Type: text/html; charset=iso-8859-1',
												'From: ' . $email['from'],
												'Reply-To: ' . !empty($email['notification']['reply']) ? $email['notification']['reply'] : $email['from']
											)
										);
										
					// Prepare response email
					$email['response']['headers'] = implode("\r\n", array(
												'MIME-Version: 1.0', 
												'Content-Type: text/html; charset=iso-8859-1',
												'From: ' . $email['from'],
												'Reply-To: ' . !empty($email['response']['reply']) ? $email['response']['reply'] : $email['from']
											)
										);
					
					// Send notification email
					if($post_id && isset($email['notification']['send'])) {
						wp_mail(
							$email['notification']['to'], 
							$email['notification']['subject'], 
							$email['notification']['content'],
							$email['notification']['headers']
						);
					}
					
					// Send response email
					if(isset($email['response']['send']) && !empty($_POST[$email['response']['to']])) {
						$email_response_to = $_POST[$email['response']['to']];
						
						$validation->set($email['response']['to'], $email_response_to)
							->email($widget_settings['messages']['email']);
						
						if($post_id && $validation::status() == true) {
							$email['response']['to'] = $email_response_to;
							
							wp_mail(
								$email['response']['to'], 
								$email['response']['subject'], 
								$email['response']['content'],
								$email['response']['headers']
							);
						}
					}
				}
			}
		}
		
		/*
		* Render shortcode's template.
		* Display meta post meta data.
		*
		* @return void
		*/
		public function set_shortcode_show_form($params)
		{
			$post_type = $params['post_type'];
			$settings  = $this->get_pb_settings($post_type);
			
			// Get widget settings
			$widget_class    = 'Widget_Paperboot_Form_' . $post_type;
			$widget_instance = new $widget_class();
			$widget_settings = end(array_values($widget_instance->get_settings()));
			
			extract(wp_parse_args((array) $widget_settings));
			
			if($display_on == 'shortcode') {
				ob_start()?> 
				
				<?php include(plugin_dir_path(__FILE__) . 'templates/widget-form.php') ?>
				
				<?PHP return ob_get_clean();
			}
		}
		
		/*
		* Render shortcode's template.
		* Display meta post meta data.
		*
		* @return void
		*/
		public function set_shortcode_show_posts($params)
		{
			$post_type = $params['post_type'];
			$settings  = $this->get_pb_settings($post_type);
			
			// Get widget settings
			$widget_class    = 'Widget_Paperboot_Form_' . $post_type;
			$widget_instance = new $widget_class();
			$widget_settings = end(array_values($widget_instance->get_settings()));
			
			extract(wp_parse_args((array) $widget_settings));
			
			$posts = get_posts(array(
				'post_type'   => $post_type,
				'order'       => 'ASC',
				'orderby'     => 'post_date',
				'post_status' => 'publish',
				'show_count'  => 1
			));
			
			if($display_on == 'shortcode') {
				ob_start()?> 
				
				<?php include(plugin_dir_path(__FILE__) . 'templates/widget-posts.php') ?>
				
				<?PHP return ob_get_clean();
			}
		}
		
		public function auto_save_disable()
		{
			wp_deregister_script('autosave');
		}

		/*
		* Custom captcha validation.
		* Compare sent captcha field value with captcha session value.
		*
		* @return bool true false
		*/
		private static function captcha()
		{
			session_start();
			
			if(htmlspecialchars($_POST['captcha']) != $_SESSION['captcha']) {
				return false;
			} else {
				return true;
			}
		}
		
		/*
		* Set example posts.
		*
		* @return bool true false
		*/
		private function set_example_posts()
		{
			$posts = get_posts(array(
				'post_type' => self::$post_type_example['post_type'])
			);
	
			if(empty($posts)) {
				$post_id = wp_insert_post(array(
					'post_type'    => $this->post_type,
					'post_content' => self::$post_type_example['post_content'], 
					'post_title'   => self::$post_type_example['post_title'],
					'post_status'  => 'publish'
				));

				foreach (self::$post_type_example as $name => $value) {
					add_post_meta($post_id, '_' . $name, $value);
				}
				
				$post_id = wp_insert_post(array(
					'post_type'    => self::$post_type_example['post_type'],
					'post_title'   => self::$post_type_example['post_title'],
					'post_content' => self::$post_type_example['post_content'], 
					'post_status'  => 'publish'
				));
				
				$fields_settings = self::$post_type_example['fields'];
				foreach($fields_settings as $field) {
					if(array_key_exists('admin_edit', $field) && $field['admin_edit'] == true) {
						add_post_meta($post_id, '_' . $field['input']['params']['name'], $field['input']['params']['value']);
					}
				}
			}
		}
		
		/*
		* Get current paper boot post type.
		* Helper function.
		*
		* @param $post_id int
		* @return $output string
		*/
		private function get_pb_post_type($post_id = null)
		{
			$output = null;
			
			if(empty($post_id)) {
				global $post;
				
				if(get_post_type($post->ID)) {
					$output = get_post_type($post->ID);
				}
				
				if(!empty($_GET['post_type'])) {
					$output = sanitize_key($_GET['post_type']);
				}
				
				if(!empty($_POST['prefix'])) {
					$output = sanitize_key($_POST['prefix']);
				}
			} else {
				$output = get_post_type($post_id);
			}

			return $output;
		}
		
		/*
		* Get current paper boot settings by post type.
		* Helper function.
		*
		* @param $post_type string
		* @return $output object
		*/
		public static function get_pb_settings($post_type)
		{
			foreach (self::$post_types as $settings) {
				if(!empty($settings['post_type']) && $settings['post_type'] === $post_type) {
					return $settings;
				}
			}
		}
		
		/*
		* Get current paper boot settings by post type.
		* Helper function.
		*
		* @param $post_type string
		* @return $output object
		*/
		public static function get_pb_field_name($field)
		{
			if(array_key_exists('input', $field) && 
				array_key_exists('params', $field['input']) && 
					!empty($field['input']['params']['name'])) {
				return $field['input']['params']['name'];
			}
		}
		
		/**
		* Capitalize string. ucfirst UTF-8 aware function 
		* Helper function.
		* 
		* @param string $string 
		* @return string 
		* @see http://ca.php.net/ucfirst 
		*/ 
		public function mb_ucfirst($string, $e ='utf-8')
		{ 
			if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) { 
				$string = mb_strtolower($string, $e); 
				$upper = mb_strtoupper($string, $e); 
				preg_match('#(.)#us', $upper, $matches); 
				$string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $e), $e); 
			} else { 
				$string = ucfirst($string); 
			}
			
			return $string; 
		}
	}
}