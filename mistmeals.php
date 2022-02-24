<?php

/**
 * Plugin Name: MistMeals Woocommerce extension
 * Plugin URI: 
 * Description: Extension for MistMeals
 * Version: 0.0.1
 * Author: Sergio Zabala Muñoz
 * Author URI: 
 * Developer: Sergio Zabala Muñoz
 * Developer URI: 
 * Text Domain: mistmeals-woocommerce-extension
 * Domain Path: /languages
 *
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if(!defined('ABSPATH')) exit;

define("MISTMEALS_PLUG_NAME", "MistMeals Plugin");
define( 'MISTMEALS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MISTMEALS_PLUGIN_FILE', __FILE__ );

require_once MISTMEALS_PLUGIN_DIR . 'load_mistmeals.php';

register_activation_hook(__FILE__, array("MistMeals","activation"));
register_deactivation_hook(__FILE__, array("MistMeals","disable"));

add_action('admin_menu', array("MistMealsMenu",'add_mistmeals_to_menu'));

// Añadir dependencias de bootstrap al plugin

function add_bootstrap ($hook) {

  if($hook != 'mistmeals-wordpress-plugin/views/view.mistmeals.php'){
    return;
  }

  wp_enqueue_script( 'bootstrapJs', plugins_url('/bootstrap/js/bootstrap.min.js',__FILE__),array('jquery'));
  wp_enqueue_style( 'bootstrapCss', plugins_url('/bootstrap/css/bootstrap.min.css',__FILE__));
  
}

function add_mistmeals_js ($hook) {

  if($hook != 'mistmeals-wordpress-plugin/views/view.mistmeals.php'){
    return;
  }
  wp_enqueue_script( 'mistmealsJs', plugins_url('/js/mistmeals_view.js', __FILE__));
  wp_enqueue_script( 'mistmealsNutrientsJS', plugins_url('/js/mistmeals_add_nutrients.js',__FILE__),array('jquery'));
 
}

add_action('admin_enqueue_scripts', 'add_bootstrap');
add_action('admin_enqueue_scripts', 'add_mistmeals_js');
add_action('wp_ajax_send_mm_data', array("MistMealsAjax", "mm_form_ajax"));

?>