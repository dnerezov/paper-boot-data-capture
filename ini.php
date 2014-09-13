<?php
/*
* @package Paper Boot Wp-plugins
*
* Plugin Name: Paper Boot Data Capture
* Description: Create multiple custom post types with relevant meta fields. Each post type has its own widget that displays the form that validates and submits data via ajax. In the admin area custom post types and their assosiative records behave and managed in the same manner as native wordpress pages or posts.
* Author: Denis Nerezov
* Version: 1.0.1
*/

include_once('pb-form.php');

new Paper_Boot_Form(get_posts(array(
	'post_type' => 'paperboot')
));