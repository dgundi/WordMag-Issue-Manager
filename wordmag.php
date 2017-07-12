<?php 
/*
Plugin Name: WordMag Issue Manager
Description: Manage your magazine cover images using a simple drag and drop tool
Version:     1.0
Author:      ImpressionWeb
Author URI:  http://www.impressionwebdesign.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) {
	header('HTTP/1.0 403 Forbidden');
	exit;
}

define('IW_WM_ROOT_FILE', __FILE__);
define('IW_WM_ROOT_PATH', dirname(__FILE__));
define('IW_WM_PLUGIN_SLUG', basename(dirname(__FILE__)));
define('IW_WM_PLUGIN_BASE', plugin_basename(__FILE__));
define('IW_WM_PLUGIN_VERSION', '1.0.0');

require_once(IW_WM_ROOT_PATH . '/class.wordmag.php');

new WordMag();

 ?>