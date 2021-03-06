<?php
/**
 * Contains Media_File_System\Admin\Admin
 *
 * @package media-file-system
 */

namespace Media_File_System\Admin;

defined( 'ABSPATH' ) || die();

use Media_File_System\Shared\AdminTrait;
use Media_File_System\Shared\BaseTrait;

/**
 * Class Admin
 *
 * @package Media_File_System
 */
class Admin {

	use BaseTrait;
	use AdminTrait;

	/** @var string Menu Slug. */
	protected $menu_slug;

	/** @var \Media_File_System\Admin\General_Form General Forms. */
	protected $general_options;

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		$this->menu_slug = 'media-file-system';

		if ( is_multisite() && is_main_network() ) {
			$this->add_actions();
		} else {
			$this->add_actions();
		}

	}

	/**
	 * A DRY method.
	 */
	protected function add_actions() : void {
		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu_rearrange' ], 11 );
		add_action( 'current_screen', [ $this, 'current_screen' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_enqueue_scripts' ] );
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
	 * Enqueue scripts.
	 *
	 * @param string $hook WordPress hook.
	 */
	public function admin_enqueue_scripts( $hook ) : void {

		if ( 'settings_page_media-file-system' === $hook ) {
			wp_enqueue_script(
				'mfs-admin-script',
				MFS_PLUGIN_URL . '/assets/js/mfs-admin-script.js',
				[],
				MFS_VERSION,
				true
			);
		}

		wp_enqueue_style( 'mfs-admin-style', MFS_PLUGIN_URL . '/assets/css/mfs-admin-style.css', [], MFS_VERSION );
	}

	/**
	 * WordPress admin init.
	 */
	public function admin_init() {

		register_setting( $this->option_group, $this->option_name );

		$this->general_options = General_Form::get_instance();

	}

	/**
	 * Admin menu.
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

		$options_sorted = [];

		$media_position             = array_search( 'options-media.php', array_column( $submenu['options-general.php'], 2 ), true ); // phpcs:ignore
		$media_file_system_position = array_search( esc_html__( 'File System', self::$text_domain ), array_column( $submenu['options-general.php'], 0 ), true ); // phpcs:ignore

		$media_file_system_menu            = array_slice( $submenu['options-general.php'], $media_file_system_position, $media_file_system_position + 1, true );
		$key                               = key( $media_file_system_menu );
		$media_file_system_menu[ $key ][4] = 'mfs-item';

		$options_sorted     += array_slice( $submenu['options-general.php'], 0, $media_position, true );
		$options_sorted[30] = $submenu['options-general.php'][30];
		$options_sorted     += $media_file_system_menu;
		$options_sorted     += array_slice( $submenu['options-general.php'], $media_position + 1, $media_file_system_position, true );
		$options_sorted     += array_slice( $submenu['options-general.php'], $media_file_system_position + 2, true );

		// Overriding WordPress Global is prohibited, not on my watch.
		$submenu['options-general.php'] = $options_sorted; // phpcs:ignore

	}

	/**
	 * Easy way to print hide tabs.
	 *
	 * @param string $active_tab Current tab.
	 * @param bool   $print Flag to print or hide nav bar.
	 */
	public function print_tabs( $active_tab, $print = true ) : void {

		if ( ! $print ) {
			return;
		}

		?>
		<h2 class="nav-tab-wrapper">
			<a href="?page=media-file-system&tab=general_options" class="nav-tab <?php echo 'general_options' === $active_tab ? esc_attr( 'nav-tab-active' ) : ''; ?>"><?php esc_html_e( 'General Options', self::$text_domain ); ?></a>
			<a href="?page=media-file-system&tab=advance_options" class="nav-tab <?php echo 'styling_options' === $active_tab ? esc_attr( 'nav-tab-active' ) : ''; ?>"><?php esc_html_e( 'Advance Options', self::$text_domain ); ?></a>
		</h2>
		<?php
	}

	/**
	 * Options screen.
	 */
	public function media_file_system_options() : void {

		$active_tab = $_GET['tab'] ?? 'general_options'; // WPCS: csrf ok.

		?>
		<div class="wrap">
			<h2><?php echo get_admin_page_title(); // WPCS: XSS ok. ?></h2>

			<?php $this->print_tabs( $active_tab, false ); ?>

			<form method="post" action="options.php">
				<?php

				$this->{$active_tab}->get_section();

				submit_button();
				?>
			</form>
		</div>
		<?php
	}
}
