<?php
/**
* Used to initiate custom widget within Paper Boot Form plugin.
* A Core class that stores all widget functionalities.
*
* @category  Library Wordpress Plugins
* @package   Paper Boot Form
* @author    Denis Nerezov <dnerezov@gmail.com>
* @copyright (c) 2014 Denis Nerezov
* @link      http://bobo.org/license
* @version   1.0.0
* @since     1.0.0
* 
**/
include_once('lib/class-pb-validator.php');
include_once('lib/class-pb-tag.php');

class Widget_Paperboot_Form_Announcements extends WP_Widget
{
	/*
	* Display if triggered by widget or shortcode
	*
	* @param string
	*/
	public $display_on   = 'widget';
	
	/*
	* Display if triggered by widget or shortcode
	*
	* @param string
	*/
	public $post_title_field = null;
	
	/*
	* Widget front panel title.
	*
	* @param string
	*/
	public $title        = 'PB Announcements';
	
	/*
	* Store user access condition.
	*
	* @param string
	*/
	public $is_authorized = false;
	
	/*
	* Store email settings.
	*
	* @param array
	*/
	public $email = array(
		'notification' => array(
			'send'    => 'on',
			'to'      => 'dnerezov@gmail.com',
			'from'    => 'dnerezov@gmail.com',
			'reply'   => 'dnerezov@gmail.com',
			'subject' => 'Announcements submissions',
			'content' => null
		),
		'response' => array(
			'to'      => null,
			'from'    => null,
			'reply'   => null,
			'subject' => null,
			'content' => null
		)
	);
	
	/*
	* Store form visibility condition.
	*
	* @param string
	*/
	public $show_form    = true;
	
	/*
	* Store record listing visibility condition.
	*
	* @param string
	*/
	public $show_listing = true;
	
	/*
	* Store form visibility condition.
	*
	* @param string
	*/
	public $show_captcha = true;
	
	/*
	* Submit button label.
	*
	* @param string
	*/
	public $submit_label = 'Send';
	
	/*
	* Submit event.
	* Store javascript.
	*
	* @param string
	*/
	public $submit_event;
	
	/*
	* Store form messages.
	*
	* @param array
	*/
	public $messages = array(
		'success'      => 'Thank you, the form has been submitted',
		'fail'         => 'Could not be sent. We apologise for the inconvenience, please resubmit later.',
		'blank'        => 'Field is required',
		'range'        => 'Please Enter value containing between min and max characters',
		'alpha'        => 'Please Use alphabetical characters only',
		'numeric'      => 'Please Use numeric characters only',
		'alphanumeric' => 'Please Use alphabetical and numeric characters only',
		'email'		   => 'Invalid email format',
		'url'          => 'Invalid url',
		'depth'        => 'Select between min and max',
		'captcha'      => 'You have entered incorrect code'
	);
	
	/*
	* Initiate plugin widget.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->title = __('Announcements', 'text_domain');
		
		parent::__construct(
			'wpb_widget_pb_form_announcements', 
			__('PB Announcements'), 
			array(
				'description' => __('Paper Boot ', 'text_domain'),
				'classname'   => '#widget_class#'
			)
		);
	}
	
	/**
	* Extract and set form fields.
	* Defines widget back-end form presentation.
	*
	* @param  	array	$instance		widget options
	* @return 	void
	*/
	public function form($instance)
	{
		$display_on    = isset($instance['display_on']) ? $instance['display_on'] : $this->display_on;
		$post_title_field = isset($instance['post_title_field']) ? $instance['post_title_field'] : $this->post_title_field;;
		
		$title         = isset($instance['title']) ? $instance['title'] : $this->title;
		$is_authorized = isset($instance['is_authorized']) ? $instance['is_authorized'] : $this->is_authorized;
		$show_form     = isset($instance['show_form']) ? $instance['show_form'] : $this->show_form;
		$show_listing  = isset($instance['show_listing']) ? $instance['show_listing'] : $this->show_listing;
		$show_captcha  = isset($instance['show_captcha']) ? $instance['show_captcha'] : $this->show_captcha;
		$submit_label  = isset($instance['submit_label']) ? $instance['submit_label'] : __($this->submit_label, 'text_domain');
		$submit_event  = isset($instance['submit_event']) ? $instance['submit_event'] : __($this->submit_event, 'text_domain');
		
		$email['notification']['send']    = isset($instance['email']['notification']['send']) ? $instance['email']['notification']['send'] : $this->email['notification']['send'];
		$email['notification']['to']      = isset($instance['email']['notification']['to']) ? $instance['email']['notification']['to'] : $this->email['notification']['to'];
		$email['notification']['from']    = isset($instance['email']['notification']['from']) ? $instance['email']['notification']['from'] : $this->email['notification']['from'];
		$email['notification']['reply']   = isset($instance['email']['notification']['reply']) ? $instance['email']['notification']['reply'] : $this->email['notification']['reply'];
		$email['notification']['content'] = isset($instance['email']['notification']['content']) ? $instance['email']['notification']['content'] : $this->email['notification']['content'];
		$email['response']['send']        = isset($instance['email']['response']['send']) ? $instance['email']['response']['send'] : $this->email['response']['send'];
		$email['response']['to']          = isset($instance['email']['response']['to']) ? $instance['email']['response']['to'] : $this->email['response']['to'];
		$email['response']['from']        = isset($instance['email']['response']['from']) ? $instance['email']['response']['from'] : $this->email['response']['from'];
		$email['response']['reply']       = isset($instance['email']['response']['reply']) ? $instance['email']['response']['reply'] : $this->email['response']['reply'];
		$email['response']['content']     = isset($instance['email']['response']['content']) ? $instance['email']['response']['content'] : $this->email['response']['content'];
		
		$messages['success']      = isset($instance['messages']['success']) ? $instance['messages']['success'] : $this->messages['success'];
		$messages['fail']         = isset($instance['messages']['fail']) ? $instance['messages']['fail'] : $this->messages['fail'];
		$messages['blank']        = isset($instance['messages']['blank']) ? $instance['messages']['blank'] : $this->messages['blank'];
		$messages['range']        = isset($instance['messages']['range']) ? $instance['messages']['range'] : $this->messages['range'];
		$messages['alpha']        = isset($instance['messages']['alpha']) ? $instance['messages']['alpha'] : $this->messages['alpha'];
		$messages['numeric']      = isset($instance['messages']['numeric']) ? $instance['messages']['numeric'] : $this->messages['numeric'];
		$messages['alphanumeric'] = isset($instance['messages']['alphanumeric']) ? $instance['messages']['alphanumeric'] : $this->messages['alphanumeric'];
		$messages['email']        = isset($instance['messages']['email']) ? $instance['messages']['email'] : $this->messages['email'];
		$messages['url']          = isset($instance['messages']['url']) ? $instance['messages']['url'] : $this->messages['url'];
		$messages['depth']        = isset($instance['messages']['depth']) ? $instance['messages']['depth'] : $this->messages['depth'];
		$messages['captcha']      = isset($instance['messages']['captcha']) ? $instance['messages']['captcha'] : $this->messages['captcha'];
		
		extract($instance) ?>
		
		<div class="pb-widget-form" id="announcements">
			<?php if (!self::get_fields()) : ?>
			<div class="message-save message-error"> 
				<p><strong><?php _e('There are no form fields created.', 'text_domain') ?></strong>
					<a href="/wp-admin/post.php?post=4&action=edit">Create fields</a>
				</p>
			</div>
			<?php endif ?>
			
			<?php if (!empty($_POST) && PB_Validator::status() == true) : ?>
			<div class="message-save message-success">
				<p><strong><?php _e('Widget Saved.', 'text_domain') ?></strong></p>
			</div>
			<?php endif ?>
			
			<?php if (!empty($_POST) && PB_Validator::status() == false) : ?>
			<div class="message-save message-error"> 
				<p><strong><?php _e('Fix the errors and save.', 'text_domain') ?></strong></p>
			</div>
			<?php endif ?>
			
			<h5><?php _e('Widget Settings', 'text_domain')?></h5>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('display_on'),
					'value' => __('Display On', 'text_domain')
				)) ?>
				<?php echo PB_Tag::select(array(
					'name'    => $this->get_field_name('display_on'),
					'id'      => $this->get_field_id('display_on'),
					'options' => array('widget' => 'Widget', 'shortcode' => 'Shortcode'),
					'value'   => $display_on,
					'checked' => $display_on == 'on' ? 'checked="checked"' : null,
					'class'   => 'widefat'
				)) ?>
			</p>
			
			<h5><?php _e('Form Settings', 'text_domain')?></h5>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('title'),
					'value' => __('Title', 'text_domain')
				)) ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('title'),
					'id'    => $this->get_field_id('title'),
					'value' => $title,
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::checkbox(array(
					'name'    => $this->get_field_name('show_form'),
					'id'      => $this->get_field_id('show_form'),
					'class'   => 'show_form checkbox',
					'checked' => $show_form == 'on' ? 'checked="checked"' : null
				)) ?>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('show_form'),
					'value' => __('Show Form', 'text_domain')
				)) ?>
			</p>
			<p class="post_title_field" <?php echo $show_form != 'on' ? 'style="display: none"' : null?>>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('post_title_field'),
					'value' => __('Nominate post title field', 'text_domain')
				)) ?>
				<p class="text-help">
					Entered value will be saved and treated as native WP post title within admin area.
				</p>
				<?php echo PB_Tag::select(array(
					'name'  => $this->get_field_name('post_title_field'),
					'id'    => $this->get_field_id('post_title_field'),
					'options' => self::get_fields(),
					'value' => $post_title_field,
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="show_captcha" <?php echo $show_form != 'on' ? 'style="display: none"' : null?>>
				<?php echo PB_Tag::checkbox(array(
					'name'    => $this->get_field_name('show_captcha'),
					'id'      => $this->get_field_id('show_captcha'),
					'class'   => 'show_captcha checkbox',
					'checked' => $show_captcha == 'on' ? 'checked="checked"' : null
				)) ?>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('show_captcha'),
					'value' => __('Show Captcha', 'text_domain')
				)) ?>
			</p>
			<p class="submit_label" <?php echo $show_form != 'on' ? 'style="display: none"' : null?>>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('submit_label'),
					'value' => __('Submit button label', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('submit_label')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('submit_label'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('submit_label'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('submit_label'),
					'id'    => $this->get_field_id('submit_label'),
					'value' => $submit_label,
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="submit_event" <?php echo $show_form != 'on' ? 'style="display: none"' : null?>>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('submit_event'),
					'value' => __('Run Sniplet On Submit', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('submit_event')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('submit_event'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('submit_event'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::textarea(array(
					'name'  => $this->get_field_name('submit_event'),
					'id'    => $this->get_field_id('submit_event'),
					'value' => $submit_event,
					'rows'  => 7,
					'class' => 'widefat'
				)) ?>
			</p>
			
			<h5><?php _e('Post Listing Settings', 'text_domain')?></h5>
			<p>
				<?php echo PB_Tag::checkbox(array(
					'name'    => $this->get_field_name('show_listing'),
					'id'      => $this->get_field_id('show_listing'),
					'class'   => 'show_listing checkbox',
					'checked' => $show_listing == 'on' ? 'checked="checked"' : null
				)) ?>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('show_listing'),
					'value' => __('Show Post Listing', 'text_domain')
				)) ?>
			</p>
			<p class="is_authorized" <?php echo $show_listing != 'on' ? 'style="display: none"' : null?>>
				<?php echo PB_Tag::checkbox(array(
					'name'    => $this->get_field_name('is_authorized'),
					'id'      => $this->get_field_id('is_authorized'),
					'class'   => 'is_authorized checkbox',
					'checked' => $is_authorized == 'on' ? 'checked="checked"' : null
				)) ?>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('is_authorized'),
					'value' => __('Require authorized access to view record listing', 'text_domain')
				)) ?>
			</p>
			
			<h5><?php _e('Notification Email Settings', 'text_domain')?></h5>
			<p class="email-notification-send">
				<?php echo PB_Tag::checkbox(array(
					'name'    => $this->get_field_name('email') . '[notification][send]',
					'id'      => $this->get_field_id('email-notification-send'),
					'class'   => 'email-notification-send',
					'checked' => $email['notification']['send'] == 'on' ? true : null
				)) ?>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-notification-send'),
					'value' => __('Send Notification Email On Submit', 'text_domain')
				)) ?>
			</p>
			<p class="email-notification-to">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-notification-to'),
					'value' => __('Send To Address', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-notification-to')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-notification-to'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-notification-to'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('email') . '[notification][to]',
					'id'    => $this->get_field_id('email-notification-to'),
					'value' => $email['notification']['to'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="email-notification-from">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-notification-from'),
					'value' => __('From Address', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-notification-from')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-notification-from'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-notification-from'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('email') . '[notification][from]',
					'id'    => $this->get_field_id('email-notification-from'),
					'value' => $email['notification']['from'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="email-notification-reply">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-notification-reply'),
					'value' => __('Reply To Address', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-notification-reply')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-notification-reply'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-notification-reply'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('email') . '[notification][reply]',
					'id'    => $this->get_field_id('email-notification-reply'),
					'value' => $email['notification']['reply'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="email-notification-subject">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-notification-subject'),
					'value' => __('Subject', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-notification-subject')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-notification-subject'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-notification-subject'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('email') . '[notification][subject]',
					'id'    => $this->get_field_id('email-notification-subject'),
					'value' => $email['notification']['subject'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="email-notification-content">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-notification-content'),
					'value' => __('Content', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-notification-content')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-notification-content'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-notification-content'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::textarea(array(
					'name'  => $this->get_field_name('email') . '[notification][content]',
					'id'    => $this->get_field_id('email-notification-content'),
					'value' => $email['notification']['content'],
					'class' => 'widefat',
					'rows'  => 7
				)) ?>
			</p>

			<h5><?php _e('Response Email Settings', 'text_domain')?></h5>
			<p class="email-response-send">
				<?php echo PB_Tag::checkbox(array(
					'name'    => $this->get_field_name('email') . '[response][send]',
					'id'      => $this->get_field_id('email-response-send'),
					'class'   => 'email-response-send',
					'checked' => $email['response']['send'] == 'on' ? true : null
				)) ?>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-response-send'),
					'value' => __('Send response Email On Submit', 'text_domain')
				)) ?>
			</p>
			<p class="email-response-to">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-response-to'),
					'value' => __('Declare Email Field', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-response-to')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-response-to'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-response-to'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::select(array(
					'name'  => $this->get_field_name('email') . '[response][to]',
					'id'    => $this->get_field_id('email-response-to'),
					'options' => self::get_fields(),
					'value' => $email['response']['to'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="email-response-from">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-response-from'),
					'value' => __('From Address', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-response-from')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-response-from'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-response-from'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('email') . '[response][from]',
					'id'    => $this->get_field_id('email-response-from'),
					'value' => $email['response']['from'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="email-response-reply">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-response-reply'),
					'value' => __('Reply To Address', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-response-reply')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-response-reply'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-response-reply'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('email') . '[response][reply]',
					'id'    => $this->get_field_id('email-response-reply'),
					'value' => $email['response']['reply'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="email-response-subject">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-response-subject'),
					'value' => __('Subject', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-response-subject')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-response-subject'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-response-subject'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('email') . '[response][subject]',
					'id'    => $this->get_field_id('email-response-subject'),
					'value' => $email['response']['subject'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p class="email-response-content">
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('email-response-content'),
					'value' => __('Content', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('email-response-content')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('email-response-content'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('email-response-content'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::textarea(array(
					'name'  => $this->get_field_name('email') . '[response][content]',
					'id'    => $this->get_field_id('email-response-content'),
					'value' => $email['response']['content'],
					'class' => 'widefat',
					'rows'  => 7
				)) ?>
			</p>

			<h5><?php _e('Messages Settings', 'text_domain')?></h5>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('success'),
					'value' => __('Successful Form Submission', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-success')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('success'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-success'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[success]',
					'id'    => $this->get_field_id('success'),
					'value' => $messages['success'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('fail'),
					'value' => __('Failed Form Submission', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-fail')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('fail'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-fail'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[fail]',
					'id'    => $this->get_field_id('fail'),
					'value' => $messages['fail'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('messages-blank'),
					'value' => __('Validation Required', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-blank')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('messages-blank'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-blank'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[blank]',
					'id'    => $this->get_field_id('messages-blank'),
					'value' => $messages['blank'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('messages-range'),
					'value' => __('Validation Range', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-range')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('messages-range'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-range'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[range]',
					'id'    => $this->get_field_id('messages-range'),
					'value' => $messages['range'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('messages-alpha'),
					'value' => __('Validation Alpha', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-alpha')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('messages-alpha'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-alpha'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[alpha]',
					'id'    => $this->get_field_id('messages-alpha'),
					'value' => $messages['alpha'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('messages-numeric'),
					'value' => __('Validation Numeric', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-numeric')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('messages-numeric'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-numeric'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[numeric]',
					'id'    => $this->get_field_id('messages-numeric'),
					'value' => $messages['numeric'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('messages-alphanumeric'),
					'value' => __('Validation Alphanumeric', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-alphanumeric')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('messages-alphanumeric'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-alphanumeric'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[alphanumeric]',
					'id'    => $this->get_field_id('messages-alphanumeric'),
					'value' => $messages['alphanumeric'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('messages-email'),
					'value' => __('Validation Email Format', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-email')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('messages-email'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-email'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[email]',
					'id'    => $this->get_field_id('messages-email'),
					'value' => $messages['email'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('messages-url'),
					'value' => __('Validation Url Format', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-url')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('messages-url'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-url'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[url]',
					'id'    => $this->get_field_id('messages-url'),
					'value' => $messages['url'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('messages-depth'),
					'value' => __('Validation Checked Items Range', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-depth')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('messages-depth'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-depth'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[depth]',
					'id'    => $this->get_field_id('messages-depth'),
					'value' => $messages['depth'],
					'class' => 'widefat'
				)) ?>
			</p>
			<p>
				<?php echo PB_Tag::label(array(
					'for'   => $this->get_field_id('messages-captcha'),
					'value' => __('Validation Captcha Format', 'text_domain')
				)) ?>
				<?php 
				if (PB_Validator::getErrors('messages-captcha')) : ?>
					<?php echo PB_Tag::label(array(
						'for'   => $this->get_field_id('messages-captcha'),
						'value' => '<strong>ERROR</strong>: ' . PB_Validator::getErrors('messages-captcha'),
						'class' => 'pb-widget-form-validation-error'
					)) ?>
				<?php endif ?>
				<?php echo PB_Tag::text(array(
					'name'  => $this->get_field_name('messages') . '[captcha]',
					'id'    => $this->get_field_id('messages-captcha'),
					'value' => $messages['captcha'],
					'class' => 'widefat'
				)) ?>
			</p>
		</div>
	<?php 
	}

	/**
	* Updates widget options.
	*
	* @param  	array	$current	current widget instance
	* @param  	array	$previous	previous/old widget instance
	* @return 	array 	$output 	updated widget instance	
	*/
	public function update($current, $previous) 
	{
		if (!empty($_POST)) {
			PB_Validator::instance()
				->set('title', $current['title'])
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 2, 'max' => 50))
				->set('submit_label', $current['submit_label'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 4, 'max' => 30));
					
			if (isset($current['email']['notification']['send'])) {
				PB_Validator::instance()
				->set('email-notification-to', $current['email']['notification']['to'])
					->email('Invalid email format')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 4, 'max' => 100))
				->set('email-notification-from', $current['email']['notification']['from'])
					->email('Invalid email format')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 4, 'max' => 100))
				->set('email-notification-reply', $current['email']['notification']['reply'])
					->email('Invalid email format')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 4, 'max' => 100))
				->set('subject', $current['email']['notification']['subject'])
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 2, 'max' => 255))
				->set('email-notification-content', $current['email']['notification']['content'])
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 2, 'max' => 1000));
			}
			
			if(isset($current['email']['response']['send'])) {
				PB_Validator::instance()
					->set('email-response-to', $current['email']['response']['to'])
						->blank('Cannot be blank')
						->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 4, 'max' => 100))
					->set('email-response-from', $current['email']['response']['from'])
						->blank('Cannot be blank')
						->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 4, 'max' => 100))
					->set('email-response-subject', $current['email']['response']['subject'])
						->blank('Cannot be blank')
						->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 4, 'max' => 100))
					->set('email-response-content', $current['email']['response']['content'])
						->blank('Cannot be blank')
						->range(__('Cannot be less than min and longer than max characters', 'text_domain'), array('min' => 2, 'max' => 1000));
			}
			
			PB_Validator::instance()
				->set('messages-success', $current['messages']['success'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-fail', $current['messages']['fail'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-blank', $current['messages']['blank'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-range', $current['messages']['range'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-alpha', $current['messages']['alpha'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-numeric', $current['messages']['numeric'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-alphanumeric', $current['messages']['alphanumeric'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-email', $current['messages']['email'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-url', $current['messages']['url'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-depth', $current['messages']['depth'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'))
				->set('messages-captcha', $current['messages']['captcha'])
					->blank('Cannot be blank')
					->alphanumeric('Alphanumeric characters only')
					->range(__('Cannot be less than min and longer than max characters', 'text_domain'));
		}

		$output = array();
		
		foreach ($this as $option_name => $option_value) {
			switch ($option_name) {
				case 'submit_event':
					$output['submit_event'] = htmlentities($current['submit_event']);
				break;

				default:
					$output[$option_name] = PB_Validator::getErrors($option_name) ? $previous[$option_name] : $current[$option_name];
			}
		}
		
		return $output;
	}
	
	/**
	* Extract widget options.
	* Defines widget front-end presentation.
	*
	* @param  	array	$args	current widget instance
	* @param  	array	$instance	previous/old widget instance
	* @return 	void
	*/
	public function widget($current, $previous)
	{
		$current['post_type'] = 'announcements';
		extract(wp_parse_args((array) $current, $previous));

		$settings = Paper_Boot_Form::get_pb_settings('announcements');
		
		$posts = get_posts(array(
			'post_type'   => 'announcements',
			'order'       => 'ASC',
			'orderby'     => 'post_date',
			'post_status' => 'publish',
			'show_count'  => 1
		));
		
		if($display_on == 'widget') {
			include(plugin_dir_path(__FILE__) . 'templates/widget.php');
		}
	}
	
	/**
	* Build List of  fields.
	*
	* @param  	array	$args	current widget instance
	* @param  	array	$instance	previous/old widget instance
	* @return 	void
	*/
	private static function get_fields($prepand_empty = false)
	{
		$output = array();
		
		$settings = Paper_Boot_Form::get_pb_settings('announcements');
		if(!empty($settings['fields'])) {
			if($prepand_empty) {
				$output[] = null;
			}
			
			foreach ($settings['fields'] as $field) {
				$output[Paper_Boot_Form::get_pb_field_name($field)] = $field['label'];
			}
		}
		
		return $output;
	}
}