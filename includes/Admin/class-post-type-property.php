<?php
/**
 * Contains Media_File_System\Admin\Post_Type_Property
 *
 * @package media-file-system
 */

namespace Media_File_System\Admin;

use Media_File_System\Shared\AdminTrait;
use Media_File_System\Shared\BaseTrait;

defined( 'ABSPATH' ) || die();

/**
 * Class Post_Type_Property
 *
 * @package Media_File_System\Admin
 */
class Post_Type_Property {

	use BaseTrait;
	use AdminTrait;

	/** @var \WP_Post_Type Post Type object. */
	protected $post_type;

	/** @var array Options Media File System. */
	protected $options;

	/**
	 * Post_Type_Property constructor.
	 *
	 * @param \WP_Post_Type $post_type Object carring the WP Post Type.
	 */
	public function __construct( \WP_Post_Type $post_type ) {
		$this->post_type = $post_type;
		$this->options   = get_option( $this->option_name );
	}

	/**
	 * Print Post Type Properties.
	 */
	public function print_field() : void {

		$base_name   = $this->option_name . '[' . $this->post_type->name . ']';
		$blog_prefix = '';

		/**
		 * In a subdirectory configuration of multisite, the `/blog` prefix is used by
		 * default on the main site to avoid collisions with other sites created on that
		 * network. If the `permalink_structure` option has been changed to remove this
		 * base prefix, WordPress core can no longer account for the possible collision.
		 */
		if ( is_multisite() && ! is_subdomain_install() && is_main_site() && 0 === strpos( get_option( 'permalink_structure' ), '/blog/' ) ) {
			$blog_prefix = '/blog';
		}

		$public_path = $this->options[ $this->post_type->name ]['public_path'] ?? '/%year%/%month%';

		$upload_dir = wp_upload_dir();
		?>
		<p><?php esc_html_e( 'Public file system path', self::$text_domain ); // phpcs:ignore ?></p>
		<code><?php echo $upload_dir['baseurl']; ?></code><input name="<?php echo esc_attr( $base_name ); ?>[public_path]" id="<?php echo esc_attr( $base_name ); ?>[public_path]" value="<?php echo esc_attr( $public_path ); ?>" placeholder="<?php esc_html_e( 'Public path from publics folder', self::$text_domain ); // phpcs:ignore ?>" class="regular-text code">
		<?php

		$this->print_tags();
	}

	/**
	 * From core section.
	 */
	public function print_tags() : void {
		?>
		<div class="available-structure-tags-<?php echo esc_attr( $this->post_type->name ); ?> hide-if-no-js">
			<div id="custom_selection_updated-<?php echo esc_attr( $this->post_type->name ); ?>" aria-live="assertive" class="screen-reader-text"></div>
			<?php
			$available_tags = [
				/* translators: %s: permalink structure tag */
				'custom_date:Y-m-d' => __( '%s (Custom date base on PHP date.)' ),
				'year'              => __( '%s (The year of the post, four digits, for example 2004.)' ),
				/* translators: %s: permalink structure tag */
				'monthnum'          => __( '%s (Month of the year, for example 05.)' ),
				/* translators: %s: permalink structure tag */
				'day'               => __( '%s (Day of the month, for example 28.)' ),
				/* translators: %s: permalink structure tag */
				'hour'              => __( '%s (Hour of the day, for example 15.)' ),
				/* translators: %s: permalink structure tag */
				'minute'            => __( '%s (Minute of the hour, for example 43.)' ),
				/* translators: %s: permalink structure tag */
				'second'            => __( '%s (Second of the minute, for example 33.)' ),
				/* translators: %s: permalink structure tag */
				'post_id'           => __( '%s (The unique ID of the post, for example 423.)' ),
				/* translators: %s: permalink structure tag */
				'postname'          => __( '%s (The sanitized post title (slug).)' ),
				/* translators: %s: permalink structure tag */
				'category'          => __( '%s (Category slug. Nested sub-categories appear as nested directories in the URL.)' ),
				/* translators: %s: permalink structure tag */
				'author'            => __( '%s (A sanitized version of the author name.)' ),
			];

			/**
			 * Filters the list of available permalink structure tags on the Permalinks settings page.
			 *
			 * @since 4.8.0
			 *
			 * @param array $available_tags A key => value pair of available permalink structure tags.
			 */
			$available_tags = apply_filters( 'available_permalink_structure_tags', $available_tags );

			/* translators: %s: permalink structure tag */
			$structure_tag_added = __( '%s added to permalink structure' );

			/* translators: %s: permalink structure tag */
			$structure_tag_already_used = __( '%s (already used in permalink structure)' );

			if ( ! empty( $available_tags ) ) :
				?>
				<p><?php esc_html_e( 'Available tags:', self::$text_domain ); ?></p>
				<ul role="list">
					<?php
					foreach ( $available_tags as $tag => $explanation ) {
						?>
						<li style="display: inline-block">
							<button type="button"
								class="button button-secondary"
								aria-label="<?php echo esc_attr( sprintf( $explanation, $tag ) ); ?>"
								data-added="<?php echo esc_attr( sprintf( $structure_tag_added, $tag ) ); ?>"
								data-used="<?php echo esc_attr( sprintf( $structure_tag_already_used, $tag ) ); ?>"
								data-field="media_file_system[<?php echo esc_attr( $this->post_type->name ); ?>][public_path]">
								<?php echo esc_attr( '{' . $tag . '}' ); ?>
							</button>
						</li>
						<?php
					}
					?>
				</ul>
			<?php endif; ?>
		</div>
		<?php
	}
}
