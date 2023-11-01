# Agnostic Icon for WordPress

## Description

This WordPress plugin allows developers and designers to use different icon libraries on their websites in a flexible and maintainable way. With a simple JSON configuration file, you can map generic icon names to specific classes from different icon libraries.

## Features

- Support for multiple icon libraries.
- Easy configuration through JSON files.
- Integration with WordPress shortcodes.

## Requirements

- WordPress 6
- PHP 8

## How to Install

1. Download the plugin and install it via the WordPress admin panel.
2. Activate the plugin.
3. Configure the `wp-config.php` file to specify which icon set to use (optional).

## Configuration in `wp-config.php`

To specify which icon set to use, you can define the `AGNOSTIC_ICON_SET` constant in your `wp-config.php` file. Currently, the valid options for this constant are:

- "icon-mapping-fontawesome" for using Font Awesome
- "icon-mapping-material" for using Material Icons
- "icon-mapping-bootstrap-icons" for using Bootstrap Icons

### Example Usage in `wp-config.php`

To use Font Awesome, add the following line to your `wp-config.php` file:

define('AGNOSTIC_ICON_SET', 'icon-mapping-fontawesome');

## Usage in templates

To use the plugin, you can either use the agnostic_icon_echo_generate_icon_html() function in your theme files or the [agnostic_icon] shortcode in your posts and pages.

## Example Usage

In templates:

To generate a Font Awesome home icon with additional classes and wrapped in a 'div' element, you can use:
```php
<?php aiw_echo_generate_icon_html('icon-home', 'my-custom-class', 'my-custom-wrapper', 'my-wrapper-class'); ?>
```

As a shortcode:

To render a home icon with additional classes and wrapped in a 'div' element, you can use:
```html
[aiw_generate_icon_html name="icon-date" class="my-custom-class" wrapper="my-custom-wrapper" wrapper_class="my-wrapper-class"]
```

## License

Agnostic Icon for WordPress is distributed under the GNU General Public License v3 or later. You can find the text of the license in the LICENSE file or at [GNU General Public License v3](http://www.gnu.org/licenses/gpl-3.0.html).