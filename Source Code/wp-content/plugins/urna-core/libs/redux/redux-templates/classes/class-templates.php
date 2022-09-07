<?php // phpcs:ignore WordPress.Files.FileName
/**
 * Templates overrides for pages.
 *
 * @since 4.0.0
 * @package Redux Framework
 */

namespace ReduxTemplates;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Redux Templates Templates Class
 *
 * @since 4.0.0
 */
class Templates {

	/**
	 * ReduxTemplates Template.
	 *
	 * @since 4.0.0
	 */
	public function __construct() {
		// Include ReduxTemplates default template without wrapper.
		add_filter( 'template_include', array( $this, 'template_include' ) );
		// Override the default content-width when using Redux templates so the template doesn't look like crao.
		add_action( 'wp', array( $this, 'modify_template_content_width' ) );

		// Add ReduxTemplates supported Post type in page template.
		$post_types = get_post_types();
		if ( ! empty( $post_types ) ) {
			foreach ( $post_types as $post_type ) {
				add_filter( "theme_{$post_type}_templates", array( $this, 'add_templates' ) );
			}
		}

	}

	/**
	 * Override the $content_width variable for themes so our templates work properly and don't look squished.
	 *
	 * @param array $to_find Template keys to check against.
	 *
	 * @since 4.0.0
	 * @return bool
	 */
	public function check_template( $to_find = array() ) {
		global $post;
		if ( ! empty( $post ) ) {
			$template = get_page_template_slug( $post->ID );
			if ( false !== strpos( $template, 'redux' ) ) {
				$test = mb_strtolower( preg_replace( '/[^A-Za-z0-9 ]/', '', $template ) );
				foreach ( $to_find as $key ) {
					if ( false !== strpos( $test, $key ) ) {
						return true;
					}
				}
			}
		}
		return false;
	}

	/**
	 * Override the $content_width variable for themes so our templates work properly and don't look squished.
	 *
	 * @since 4.0.0
	 */
	public function modify_template_content_width() {
		$to_find = array( 'cover', 'canvas', 'fullwidth' );
		if ( $this->check_template( $to_find ) ) {
			global $content_width;
			if ( $content_width < 1000 ) {
				$content_width = 1200;
			}
		}
	}

	/**
	 * Include the template
	 *
	 * @param string $template Template type.
	 *
	 * @return string
	 * @since 4.0.0
	 */
	public function template_include( $template ) {
		if ( is_singular() ) {
			$page_template = get_post_meta( get_the_ID(), '_wp_page_template', true );
			if ( 'redux-templates_full_width' === $page_template ) {
				$template = REDUXTEMPLATES_DIR_PATH . 'classes/templates/template-full-width.php';
			} elseif ( 'redux-templates_contained' === $page_template ) {
				$template = REDUXTEMPLATES_DIR_PATH . 'classes/templates/template-contained.php';
			} elseif ( 'redux-templates_canvas' === $page_template ) {
				$template = REDUXTEMPLATES_DIR_PATH . 'classes/templates/template-canvas.php';
			}
		}

		return $template;
	}

	/**
	 * Hook to add the templates to the dropdown
	 *
	 * @param array $post_templates Default post templates array.
	 *
	 * @return array
	 * @since 4.0.0
	 */
	public function add_templates( $post_templates ) {
		$post_templates['redux-templates_contained']  = __( 'Redux Contained', 'redux-framework' );
		$post_templates['redux-templates_full_width'] = __( 'Redux Full Width', 'redux-framework' );
		$post_templates['redux-templates_canvas']     = __( 'Redux Canvas', 'redux-framework' );

		return $post_templates;
	}
}
