<?php
add_action(
	'wp_enqueue_scripts',
	function () {
		$theme = wp_get_theme();
		$textdomain = $theme->get('TextDomain') ?: 'sitedomain';

		wp_enqueue_style($textdomain . '-global-style', get_stylesheet_uri()); // для корневого style.css
		wp_enqueue_style($textdomain . '-fonts-style', get_template_directory_uri() . '/assets/fonts.css');
		wp_enqueue_style($textdomain . '-main-style', get_template_directory_uri() . '/assets/style.css');
	}
);