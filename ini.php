<?php
/*
* @package Paper Boot Wp-plugins
*
* Plugin Name: Paper Boot Form
* Description: Submit form, manage records.
* Author: Denis Nerezov
* Version: 1.0
*/

include_once('pb-form.php');

new Paper_Boot_Form(get_posts(array(
	'post_type' => 'paperboot')
));