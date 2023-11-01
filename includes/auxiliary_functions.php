<?php
/**
 * Auxiliary functions for the Agnostic Icon for WordPress plugin.
 *
 * This file contains auxiliary functions that act as wrappers for
 * the plugin's main functionality, providing shorthand methods for
 * generating and echoing icon HTML.
 *
 * @package WordPress
 * @subpackage AgnosticIconWordPress
 * @author Alexandre Kozoubsky
 *
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Generate the HTML markup for an icon based on its generic name.
 *
 * This function is an auxiliary wrapper for the generate_icon_html() method in AgnosticIconClass.
 * It allows for easier usage within templates.
 *
 * @param string $generic_name The generic name of the icon.
 * @param string $additional_classes Additional classes to add to the icon (optional).
 * @param string $wrapper_element The HTML element to wrap the icon in (optional).
 * @param string $wrapper_classes Classes to add to the wrapper element (optional).
 * @return string The HTML markup for the icon.
 */
function aiw_generate_icon_html($generic_name, $additional_classes = '', $wrapper_element = '', $wrapper_classes = '') {
    global $agnostic_icon_instance;
    return $agnostic_icon_instance->generate_icon_html($generic_name, $additional_classes, $wrapper_element, $wrapper_classes);
}

/**
 * Output the HTML markup for an icon based on its generic name.
 *
 * This function is an auxiliary wrapper for the echo_generate_icon_html() method in AgnosticIconClass.
 * It allows for easier usage within templates by directly echoing the icon HTML.
 *
 * @param string $generic_name The generic name of the icon.
 * @param string $additional_classes Additional classes to add to the icon (optional).
 * @param string $wrapper_element The HTML element to wrap the icon in (optional).
 * @param string $wrapper_classes Classes to add to the wrapper element (optional).
 */
function aiw_echo_generate_icon_html($generic_name, $additional_classes = '', $wrapper_element = '', $wrapper_classes = '') {
    global $agnostic_icon_instance;
    echo $agnostic_icon_instance->generate_icon_html($generic_name, $additional_classes, $wrapper_element, $wrapper_classes);
}
