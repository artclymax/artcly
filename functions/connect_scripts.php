<?php
add_action(
	'wp_enqueue_scripts',
	function () {
		$theme = wp_get_theme();
		$textdomain = $theme->get('TextDomain') ?: 'sitedomain';

		wp_enqueue_script($textdomain . '-main-script', get_template_directory_uri() . '/assets/main.js', array(), false, true);
	}
);