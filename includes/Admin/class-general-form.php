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

	/** @var array Options Media File System. */
	protected $options;

	/**
	 * General_Form constructor.
	 */
	public function __construct() {
		$this->options = get_option( $this->option_name );

		add_settings_section( self::SECTION_OPTION_ID, esc_html__( 'General Options', self::$text_domain ), [ $this, 'general_settings_section' ], $this->section_page ); // phpcs:ignore

		add_settings_field( 'post_types', esc_html__( 'Posts types', self::$text_domain ), [ $this, 'post_types_field' ], $this->section_page, self::SECTION_OPTION_ID ); // phpcs:ignore

		if ( isset( $this->options['post_type'] ) && count( $this->options['post_type'] ) ) {
			foreach ( $this->options['post_type'] as $post_type_name ) {
				$post_type = get_post_types( [ 'name' => $post_type_name ], 'object' )[ $post_type_name ];

				$post_type_property = new Post_Type_Property( $post_type );
				add_settings_field(
					'post_type-' . $post_type->name,
					esc_html__( $post_type->label . ' property', self::$text_domain ), // phpcs:ignore
					[ $post_type_property, 'print_field' ],
					$this->section_page,
					self::SECTION_OPTION_ID
				);
			}
		}
	}

	/**
	 * Section callback.
	 */
	public function general_settings_section() : void {
		?>
		<p>General Section Page</p>
		<?php
	}

	/**
	 * Field for test.
	 */
	public function post_types_field() : void {

		vprintf(
			'<p>%s</p>',
			[
				esc_html__( 'Select which post type would you like to customize the file system.', self::$text_domain ), // phpcs:ignore
			]
		);

		echo '<ul>';
		echo $this->list_posts_types(); // WPCS: XSS ok.
		echo '</ul>';

	}

	/**
	 * Fetch posts types options.
	 *
	 * @return string Options post type.
	 */
	protected function list_posts_types() : string {

		$options = array_map(
			function ( $post_type ) {
				if ( 'attachment' === $post_type->name ) {
					return;
				}

				$checked = ! empty( $this->options['post_type'][ $post_type->name ] ) ? 'checked' : '';

				return '<li><label for="post-type-' . $post_type->name . '">' . $post_type->label . '</label><input type="checkbox" id="post-type-' . $post_type->name . '" name="' . $this->option_name . '[post_type][' . $post_type->name . ']" value="' . $post_type->name . '" ' . $checked . '></li>';
			},
			get_post_types( [ 'public' => true ], 'objects' )
		);

		return implode( PHP_EOL, $options );
	}
}
