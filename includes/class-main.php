<?php
/**
 * Contains Media_File_System\Main
 *
 * @package media-file-system
 */

namespace Media_File_System;

defined( 'ABSPATH' ) || die();

use Media_File_System\Admin\Admin;
use Media_File_System\Shared\BaseTrait;

/**
 * Class Main
 *
 * @package Media_File_System
 */
class Main {

	use BaseTrait;

	/**
	 * Main constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ] );

		if ( is_admin() ) {
			Admin::get_instance();
		}
	}

	/**
	 * Hook: plugins_loaded.
	 */
	public function plugins_loaded() : void {
		load_plugin_textdomain( self::$text_domain, false, self::$text_domain_path );
	}
}
