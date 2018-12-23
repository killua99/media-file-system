<?php
/**
 * Contains Media_File_System\Admin\Admin
 *
 * @package media-file-system
 */

namespace Media_File_System\Admin;

defined( 'ABSPATH' ) || die();

use Media_File_System\Shared\BaseTrait;

/**
 * Class Admin
 *
 * @package Media_File_System
 */
class Admin {

	use BaseTrait;

	/** @var string Menu Slug. */
	protected $menu_slug;

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu_rearrange' ], 11 );
		add_action( 'current_screen', [ $this, 'current_screen' ] );
		$this->menu_slug = 'media-file-system';
	}

	/**
	 * Edit screen Media.
	 *
	 * @param \WP_Screen $current_screen Screen object.
	 */
	public function current_screen( $current_screen ) : void {
		if ( 'options-media' !== $current_screen->id ) {
			return;
		}

		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
	}

	/**
	 * Enqueue scripts needed.
	 */
	public function admin_enqueue_scripts() : void {

	}

	/**
	 * Admin init
	 */
	public function admin_menu() : void {
		add_options_page(
			esc_html__( 'File System', self::$text_domain ), // phpcs:ignore
			esc_html__( 'File System', self::$text_domain ), // phpcs:ignore
			'manage_options',
			$this->menu_slug,
			[ $this, 'media_file_system_options' ]
		);

	}

	/**
	 * Fix position for a nicer view.
	 */
	public function admin_menu_rearrange() : void {
		global $submenu;

	}

	/**
	 * Options screen.
	 */
	public function media_file_system_options() {
		echo 'sss';
	}
}
