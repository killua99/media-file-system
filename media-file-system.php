<?php
/**
 * Media File System
 *
 * @package media-file-system
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 or higher
 * @wordpress-plugin
 *
 * Plugin Name:  Media File System
 * Plugin URI:   https://github.com/killua99/media-file-system
 * Description:  Enhance the Media File System
 * Text Domain:  media-file-system
 * Domain Path:  /languages/
 * Version:      0.1
 * Requires PHP: 7.1
 * Author:       Luigi Guevara <guevara.luigi@gmail.com>
 * Author URI:   https://killua.me/
 * License:      GPL-2.0+
 */

defined( 'ABSPATH' ) || die();

define( 'MFS_VERSION', '0.1.0' );
define( 'MFS_FILE', __FILE__ );
define( 'MFS_PLUGIN_PATH', __DIR__ );
define( 'MFS_PLUGIN_URL', plugins_url( '/', MFS_FILE ) );

if ( ! class_exists( \Media_File_System\Main::class ) && is_file( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

\Media_File_System\Main::get_instance();
