<?php

add_action('after_setup_theme', function () {
	$theme = wp_get_theme();
	$textdomain = $theme->get('TextDomain') ?: 'sitedomain';

	register_nav_menus(
		array(
			'header-menu' => __('Меню шапки', $textdomain),
			'footer-menu' => __('Меню подвала', $textdomain),
			'services-menu' => __('Меню услуг', $textdomain),
		)
	);
});

add_filter('nav_menu_link_attributes', function ($atts) {

	// Только если есть href
	if (empty($atts['href'])) {
		return $atts;
	}

	// ---- 1. Если мы на архиве CPT ----
	if (is_post_type_archive()) {
		$post_type = get_query_var('post_type'); // текущий CPT

		if (is_array($post_type)) {
			$post_type = reset($post_type);
		}

		// Если ссылка меню ведёт на архив этого CPT
		if (strpos($atts['href'], $post_type) !== false) {
			$atts['aria-current'] = 'page';
		}
	}

	// ---- 2. Если мы на записи CPT ----
	if (is_singular()) {
		$post_type = get_post_type(); // текущий CPT

		// Если ссылка ведёт на архив или на любую страницу CPT
		if (strpos($atts['href'], $post_type) !== false) {
			$atts['aria-current'] = 'page';
		}
	}

	return $atts;
});