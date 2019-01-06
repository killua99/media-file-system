<?php
/**
 * Contains Media_File_System\Admin\Post_Type_Property
 *
 * @package media-file-system
 */

namespace Media_File_System\Admin;

defined( 'ABSPATH' ) || die();

/**
 * Class Post_Type_Property
 *
 * @package Media_File_System\Admin
 */
class Post_Type_Property {

	/** @var \WP_Post_Type Post Type object. */
	protected $post_type;

	/**
	 * Post_Type_Property constructor.
	 *
	 * @param \WP_Post_Type $post_type Object carring the WP Post Type.
	 */
	public function __construct( \WP_Post_Type $post_type ) {
		$this->post_type = $post_type;
	}

	/**
	 * Print Post Type Properties.
	 */
	public function print_field() : void {
		// We do our stuff here.
		print $this->post_type->name;
	}
}
