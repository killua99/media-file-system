<?php
/**
 * Contains Media_File_System\Shared\BaseTrait
 *
 * @package media-file-system
 */

namespace Media_File_System\Shared;

defined( 'ABSPATH' ) || die();

trait BaseTrait {

	/** @var self */
	protected static $instance;

	/** @var string Plugin Slug. */
	protected static $plugin_slug = 'media-file-system';

	/** @var string Text Domain. */
	protected static $text_domain = 'media-file-system';

	/** @var string Text Domain Path. */
	protected static $text_domain_path = MFS_PLUGIN_PATH . '/languages';

	/**
	 * Get class instance
	 *
	 * @return self
	 */
	public static function get_instance() : self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}
