<?php
/*
Plugin Name: Udimi tools
Plugin URI:  https://udimi.com
Description: This plugin automatically inserts Udimi Optin tracking code or Udimi greyboxes to your site.
Version:     3.1
Author:      Udimicom, Limited
Author URI:  http://udimi.com
*/
defined('ABSPATH') or die( 'Access denied' );

require_once(dirname(__FILE__).'/class.php');

$udimiOptin = new UdimiOptin();

$udimiOptin->updateScript();

add_action('wp_head',array($udimiOptin, 'addHeadScripts'));
add_action('admin_menu', array($udimiOptin, 'addAdminMenu'));
add_action('admin_enqueue_scripts', array($udimiOptin, 'addAdminScript'));
add_action( 'wp_ajax_connect', array($udimiOptin, 'ajax_connect'));
add_action( 'wp_ajax_disconnect', array($udimiOptin, 'ajax_disconnect'));
