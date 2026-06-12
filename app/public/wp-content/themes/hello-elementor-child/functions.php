<?php
/**
 * Hello Elementor Child Theme functions
 *
 * @package HelloElementorChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue parent and child theme styles.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		$parent_style = 'hello-elementor-parent-style';

		wp_enqueue_style(
			$parent_style,
			get_template_directory_uri() . '/style.css',
			[],
			wp_get_theme( 'hello-elementor' )->get( 'Version' )
		);

		wp_enqueue_style(
			'hello-elementor-child-style',
			get_stylesheet_uri(),
			[ $parent_style ],
			wp_get_theme()->get( 'Version' )
		);
	}
);
