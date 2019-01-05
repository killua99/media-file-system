<?php
/**
 * Contains Media_File_System\Shared\AdminTrait
 *
 * @package media-file-system
 */

namespace Media_File_System\Shared;

defined( 'ABSPATH' ) || die();

/**
 * Trait AdminTrait
 *
 * @package Media_File_System\Shared
 */
trait AdminTrait {

	/** @var string Option Group. */
	protected $option_group = 'media_file_system_options';

	/**
	 * Callback section.
	 */
	public function get_section() : void {
		settings_fields( $this->option_group );
		do_settings_sections( $this->section_page );
	}

}
