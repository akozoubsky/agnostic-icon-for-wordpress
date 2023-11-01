<?php
/**
 * Plugin Name: Agnostic Icon for WordPress
 * Description: A plugin for managing icons in an agnostic manner, allowing for switching between different icon libraries.
 * Version: 1.0.0
 * Author: Alexandre Kozoubsky
 *
 * @package WordPress
 * @subpackage AgnosticIconWordPress
 * @author Alexandre Kozoubsky
 *
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html 
 */

// Include the class file
include(plugin_dir_path(__FILE__) . 'includes/AgnosticIconClass.php');

// Instantiate the class
$agnostic_icon_instance = new AgnosticIconClass();

// Auxiliary functions
include(plugin_dir_path(__FILE__) . 'includes/auxiliary_functions.php');
?>
