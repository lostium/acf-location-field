# ACF { Location Field

Google Maps field type for the [Advanced Custom Fields](http://wordpress.org/extend/plugins/advanced-custom-fields/) WordPress plugin.

-----------------------

### Overview

This WP plugin adds a Google Map Location field tpye to the Advanced Custom Fields plugin for both versions 3 & 4. This field allows you to find addresses and coordinates of a desired location.

The Location field provides:

* a search field where you can type in some coordinates or an address and hit `Enter`. 
* a Google map which you can click at the desired location.

In both cases, Google will find the location and return the coordinates and the complete address, if you want it complete. A marker will be added at the desired location.


### Compatibility

This plugin has been written to work for both versions 3 & 4 of ACF


### Installation

This plugin can be treated as both a WP plugin and a theme include.

= Plugin =
1. Copy the 'acf-location' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

= Include =
1. Copy the 'acf-location' folder into your theme folder (can use sub folders)
   * You can place the folder anywhere inside the 'wp-content' directory
2. Edit your functions.php file and add the following code to include the field:

`
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
	include_once('acf-location/acf-location.php');
}
`

3. Make sure the path is correct to include the acf-location.php file


### More Information

Please read the readme.txt file for mor information