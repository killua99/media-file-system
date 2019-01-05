<?php
/**
 * Contains Media_File_System\Admin\General_Form
 *
 * @package media-file-system
 */

namespace Media_File_System\Admin;

defined( 'ABSPATH' ) || die();

use Media_File_System\Shared\AdminTrait;
use Media_File_System\Shared\BaseTrait;

/**
 * Class General_Form
 *
 * @package Media_File_System\Admin
 */
class General_Form {

	use BaseTrait;
	use AdminTrait;

	/** @var string Section Page. */
	private $section_page = 'general_options';

	/** @var string Section ID. */
	private const SECTION_OPTION_ID = 'general';

	/**
	 * General_Form constructor.
	 */
	public function __construct() {
		add_settings_section( self::SECTION_OPTION_ID, esc_html__( 'General Options', self::$text_domain ), [ $this, 'general_settings_section' ], $this->section_page ); // phpcs:ignore

		add_settings_field( 'general_field', esc_html__( 'General Options', self::$text_domain ), [ $this, 'general_field' ], $this->section_page, self::SECTION_OPTION_ID ); // phpcs:ignore
	}

	/**
	 * Section callback.
	 */
	public function general_settings_section() {
		?>
		<p>General Section Page</p>
		<?php
	}

	/**
	 * Field for test.
	 */
	public function general_field() {
		?>
		Le fields
		<?php
	}
}
