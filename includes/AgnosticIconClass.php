<?php
class AgnosticIconClass {
    public function __construct() {
        add_action('init', array($this, 'init')); // Hook for plugin initialization
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles')); // Hook to enqueue scripts and styles
        add_shortcode('aiw_generate_icon_html', array($this, 'render_icon')); // Register the shortcode
    }

    /* Load the icon mapping based on the global constant AGNOSTIC_ICON_SET
    * Configuration in wp-config.php:
    * To specify which icon set to use, you can define the `AGNOSTIC_ICON_SET` constant in your `wp-config.php` file.
    * Currently, the valid options for this constant are:
    * - "icon-mapping-fontawesome" for using Font Awesome
    * - "icon-mapping-material" for using Material Icons
    * - "icon-mapping-bootstrap-icons" for using Bootstrap Icons
    */
    public function init() {
        $icon_set = defined('AGNOSTIC_ICON_SET') ? AGNOSTIC_ICON_SET : 'icon-mapping-fontawesome';
        $icon_mapping = $this->load_icon_mapping($icon_set);
    }

    public function enqueue_styles() {
        // Identifies the icon library currently in use
        $icon_set = defined('AGNOSTIC_ICON_SET') ? AGNOSTIC_ICON_SET : 'icon-mapping-fontawesome';

        // Loads the corresponding stylesheet
        switch ($icon_set) {
            case 'icon-mapping-fontawesome':
                wp_enqueue_style('font-awesome-ais', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
                break;
            case 'icon-mapping-material':
                wp_enqueue_style('material-icons-ais', 'https://fonts.googleapis.com/icon?family=Material+Icons');
                //wp_enqueue_style('material-icons-ais', 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200');
                break;
            case 'icon-mapping-bootstrap-icons':
                wp_enqueue_style('bootstrap-icons-ais', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css');
                break;
            default:
                // You can add more cases for other libraries here
                break;
        }
    }

    /**
     * Load the icon mapping from the specified JSON file.
     *
     * @param string $icon_set Name of the icon mapping file (without extension).
     * @return array Icon mapping.
     *
     * @package WordPress
     * @subpackage AgnosticIconWordPress
     * @author Alexandre Kozoubsky
     *
     * License: GNU General Public License v3 or later
     * License URI: http://www.gnu.org/licenses/gpl-3.0.html
     */
    public function load_icon_mapping($icon_set) {

        $json_path = plugin_dir_path(__FILE__) . '../assets/json/' . $icon_set . '.json';

        if (file_exists($json_path)) {
            $json_content = file_get_contents($json_path);
            $decoded_json = json_decode($json_content, true);

            if (isset($decoded_json['icon_type']) && isset($decoded_json['icons']) && isset($decoded_json['base_class'])) {
                return $decoded_json;
            } else {
                // Log the error and return an empty array
                error_log("Error: Malformed icon mapping file '{$icon_set}.json'.");
                return array('icon_type' => '', 'base_class' => '', 'icons' => array());
            }
        } else {
            // Log the error and return an empty array
            error_log("Error: The icon mapping file '{$icon_set}.json' was not found.");
            return array('icon_type' => '', 'base_class' => '', 'icons' => array());
        }
    }

    /**
     * Generate the HTML markup for an icon based on its generic name, with optional additional classes and wrapper element.
     * 
     * This function generates the HTML markup for an icon based on a generic name provided. The function supports additional customization,
     * such as adding extra classes to the icon or wrapping the icon in another HTML element.
     *
     * @param string $generic_name The generic name of the icon.
     * @param string $additional_classes Additional classes to add to the icon element (optional).
     * @param string $wrapper_element The HTML tag name for an optional wrapper element around the icon (optional).
     * @param string $wrapper_classes Classes to add to the optional wrapper element (optional).
     * @return string The HTML markup for the icon.
     *
     * @example
     * To generate a Font Awesome home icon with additional classes and wrapped in a 'div' element, you can use:
     * generate_icon_html('icon-home', 'my-custom-class', 'div', 'my-wrapper-class');
     */
    public function generate_icon_html($generic_name, $additional_classes = '', $wrapper_element = '', $wrapper_classes = '') {

        // Load the icon mapping and type
        $icon_set = defined('AGNOSTIC_ICON_SET') ? AGNOSTIC_ICON_SET : 'icon-mapping-fontawesome';
        $icon_data = $this->load_icon_mapping($icon_set);
        $icon_type = $icon_data['icon_type'];
        $base_class = $icon_data['base_class'];
        $icon_mapping = $icon_data['icons'];

        // Initialize the icon markup
        $icon_markup = '';

        // Check if the icon mapping exists
        if (isset($icon_mapping[$generic_name])) {
            $icon_value = $icon_mapping[$generic_name];

            if ($icon_type === 'class-based') {
                $icon_markup = "<i class=\"{$base_class} {$icon_value} {$additional_classes}\"></i>";
            } elseif ($icon_type === 'text-based') {
                $icon_markup = "<span class=\"{$base_class} {$additional_classes}\">{$icon_value}</span>";
            }
        } else {
            // Log the error and return an empty string
            error_log("Error: The generic icon '{$generic_name}' was not found in the {$icon_set} mapping.");
            return '';
        }

        // Wrap the icon markup if a wrapper element is specified
        if (!empty($wrapper_element)) {
            $icon_markup = "<{$wrapper_element} class=\"{$wrapper_classes}\">{$icon_markup}</{$wrapper_element}>";
        }

        return $icon_markup;

    }

    /**
     * Output the HTML markup for an icon based on its generic name, with optional additional classes and wrapper element.
     *
     * @param string $generic_name The generic name of the icon.
     * @param string $additional_classes Additional classes to add to the <i> element (optional).
     * @param string $wrapper_element The HTML tag name for an optional wrapper element (optional).
     * @param string $wrapper_classes Classes to add to the optional wrapper element (optional).
     * 
     * @example:
     * $agnostic_icon_instance = new AgnosticIconClass();
     * $agnostic_icon_instance->echo_generate_icon_html("icon-date", "me-2");
     */
    public function echo_generate_icon_html($generic_name, $additional_classes = '', $wrapper_element = '', $wrapper_classes = '') {
        echo $this->generate_icon_html($generic_name, $additional_classes, $wrapper_element, $wrapper_classes);
    }

    /**
     * Render an icon based on the provided generic name and shortcode attributes.
     * 
     * This function uses the `generate_icon_html()` function to generate the HTML markup for an icon.
     * It supports additional shortcode attributes for customization such as adding extra classes or wrapping the icon in another HTML element.
     *
     * @param array $atts Shortcode attributes. Supports the following keys:
     *                    - 'name' (string): The generic name of the icon.
     *                    - 'class' (string): Additional classes to add to the icon.
     *                    - 'wrapper' (string): HTML tag to wrap around the icon (e.g., 'div', 'span').
     *                    - 'wrapper_class' (string): Classes to add to the wrapper element.
     * @return string HTML markup for the icon, potentially wrapped in a specified HTML element.
     *
     * @example
     * To render a home icon with additional classes and wrapped in a 'div' element, you can use:
     * [icon name="icon-home" class="my-custom-class" wrapper="div" wrapper_class="my-wrapper-class"]
     */
    public function render_icon($atts) {
        // Default attributes
        $atts = shortcode_atts(array(
            'name' => 'default',
            'class' => '',
            'wrapper' => '',
            'wrapper_class' => ''
        ), $atts, 'icon');

        // Use the generate_icon_html function to get the icon HTML
        return $this->generate_icon_html($atts['name'], $atts['class'], $atts['wrapper'], $atts['wrapper_class']);
    }
}
