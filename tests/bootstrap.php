<?php

/**
 * Contains Media_File_System_PhpUnit\Media_File_System_Bootstrap.
 *
 * PHPUnit bootstrap file
 *
 * @package media-file-system
 */

namespace Media_File_System_PhpUnit;

/**
 * Class Media_File_System_Bootstrap.
 */
class Media_File_System_Bootstrap {

	/**
	 * WordPress Tests Directory.
	 *
	 * @var string
	 */
	public $tests_dir;

	/**
	 * WordPress Core Directory.
	 *
	 * @var string
	 */
	public $core_dir;

	/**
	 * Plugin Dir
	 *
	 * @var string
	 */
	public $plugin_dir;

	/**
	 * wp-content dir.
	 *
	 * @var string
	 */
	public $content_dir;

	/**
	 * Singlenton
	 *
	 * @var self
	 */
	protected static $instance;

	/**
	 * Media_File_System_Bootstrap constructor.
	 */
	public function __construct() {

		$this->tests_dir = ! empty( getenv( 'WP_TESTS_DIR' ) ) ? getenv( 'WP_TESTS_DIR' ) : rtrim( sys_get_temp_dir(), '/\\' ) . '/wordpress-tests-lib';

		if ( ! file_exists( $this->tests_dir . '/includes/functions.php' ) ) {
			echo "Could not find $this->tests_dir/includes/functions.php, have you run test/bin/install.sh ?"; // WPCS: XSS ok.
			exit( 1 );
		}

		// Give access to tests_add_filter() function.
		require_once $this->tests_dir . '/includes/functions.php';

		$this->plugin_dir  = dirname( __DIR__ );
		$this->content_dir = dirname( __DIR__ ) . '/public/wp-content';

		// Load Plugins
		tests_add_filter( 'muplugins_loaded', [ $this, 'load' ] );

		// Start up the WP testing environment.
		require_once $this->tests_dir . '/includes/bootstrap.php';

	}

	/**
	 * Load Plugins.
	 */
	public function load() : void {

		$plugins_to_active = [
			'media-file-system/media-file-system.php',
		];

		update_option( 'active_plugins', $plugins_to_active );

		require_once \dirname( __DIR__ ) . '/vendor/autoload.php';

		require_once $this->plugin_dir . '/media-file-system.php';

	}

	/**
	 * Access to the single instance of the class.
	 *
	 * @return self
	 */
	public static function instance() : self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Media_File_System_Bootstrap::instance();
