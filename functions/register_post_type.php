<?php


add_action('init', function () {
	register_post_type('projects', array(
		'labels' => array(
			'name' => 'Кейсы',
			'singular_name' => 'Кейсы',
			'menu_name' => 'Кейсы',
			'name_admin_bar' => 'Кейсы',
			'add_new' => 'Добавить проект',
			'add_new_item' => 'Добавить новый проект',
			'new_item' => 'Новый проект',
			'edit_item' => 'Редактировать проект',
			'view_item' => 'Посмотреть проект',
			'all_items' => 'Все проекты',
			'search_items' => 'Поиск проектов',
			'not_found' => 'Проекты не найдены',
			'not_found_in_trash' => 'Проекты не найдены в корзине',
		),
		'public' => true,
		'public_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => [
			'slug' => 'projects',
			'with_front' => false,
			'pages' => true, // важно для /page/2/
			'feeds' => true
		],
		'capability_type' => 'post',
		'has_archive' => true, // true
		'hierarchical' => true,
		'menu_position' => 3,
		'menu_icon' => 'dashicons-portfolio',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', ),
		'show_in_rest' => false, //! редактор гутенберг

	));
});

// таксономия
register_taxonomy('projects_category', ['projects'], [
	'label' => '',
	'labels' => [
		'name' => 'Категории проектов',
		'singular_name' => 'Категория проектов',
		'search_items' => 'Поиск категории',
		'all_items' => 'Все категории',
		'parent_item' => 'Родительская категория',
		'parent_item_colon' => 'Родительская категория:',
		'edit_item' => 'Редактировать категорию',
		'update_item' => 'Обновить категорию',
		'add_new_item' => 'Добавить новую категорию',
		'new_item_name' => 'Название новой категории',
		'menu_name' => 'Категории',
		'back_to_items' => '← Назад к категориям',
	],
	'description' => '', // описание таксономии
	'public' => true,
	'hierarchical' => true, // для подкатегорий

	'rewrite' => array('slug' => 'projects_category'),

	'capabilities' => array(),
	'meta_box_cb' => null,
	'show_admin_column' => false,
	'show_in_rest' => true,
	'rest_base' => null,
	'default_term' => [
		'name' => 'Все',
		'slug' => 'all',
		'description' => 'Все проекты',
	],
]);
//! all - для всех проектов
add_action('save_post_projects', 'force_all_category_projects', 10, 3);
function force_all_category_projects($post_id, $post, $update)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
	if ($post->post_type !== 'projects')
		return;

	$all_term = get_term_by('slug', 'all', 'category');
	if (!$all_term)
		return;

	$terms = wp_get_post_terms($post_id, 'category', ['fields' => 'ids']);

	if (!in_array($all_term->term_id, $terms)) {
		$terms[] = $all_term->term_id;
		wp_set_post_terms($post_id, $terms, 'category');
	}
}

add_action('init', function () {
	register_post_type('reviews', array(
		'labels' => array(
			'name' => 'Отзывы',
			'singular_name' => 'Отзывы',
			'menu_name' => 'Отзывы',
			'name_admin_bar' => 'Отзывы',
			'add_new' => 'Добавить отзыв',
			'add_new_item' => 'Добавить новый отзыв',
			'new_item' => 'Новый отзыв',
			'edit_item' => 'Редактировать отзыв',
			'view_item' => 'Посмотреть отзыв',
			'all_items' => 'Все отзывы',
			'search_items' => 'Поиск отзывов',
			'not_found' => 'Отзывы не найдены',
			'not_found_in_trash' => 'Отзывы не найдены в корзине',
		),
		'public' => true,
		'public_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => [
			'slug' => 'reviews',
			'with_front' => false,
			'pages' => true, // важно для /page/2/
			'feeds' => true
		],
		'capability_type' => 'post',
		'has_archive' => true, // true
		'hierarchical' => true,
		'menu_position' => 3,
		'menu_icon' => 'dashicons-testimonial',
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', ),
		'show_in_rest' => false, //! редактор гутенберг

	));
});

add_action('init', function () {
	register_post_type('blog', array(
		'labels' => array(
			'name' => 'Блог',
			'singular_name' => 'Запись блога',
			'menu_name' => 'Блог',
			'name_admin_bar' => 'Запись блога',
			'add_new' => 'Добавить запись',
			'add_new_item' => 'Добавить новую запись',
			'new_item' => 'Новая запись',
			'edit_item' => 'Редактировать запись',
			'view_item' => 'Посмотреть запись',
			'all_items' => 'Все записи',
			'search_items' => 'Поиск записей',
			'not_found' => 'Записи не найдены',
			'not_found_in_trash' => 'Записи не найдены в корзине',
			'parent_item_colon' => 'Родительская запись:',
		),

		'public' => true,
		'public_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,

		'rewrite' => array(
			'slug' => 'blog',
			'with_front' => false,
			'pages' => true,
			'feeds' => true,
		),

		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => true,
		'menu_icon' => 'dashicons-welcome-write-blog',
		'menu_position' => 3,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'custom-fields',
			'page-attributes',
		),

		'show_in_rest' => true
	));
});

add_action('init', function () {
	register_post_type('team', array(
		'labels' => array(
			'name' => 'Команда',
			'singular_name' => 'Участник команды',
			'menu_name' => 'Команда',
			'name_admin_bar' => 'Участник команды',
			'add_new' => 'Добавить участника',
			'add_new_item' => 'Добавить нового участника',
			'new_item' => 'Новый участник',
			'edit_item' => 'Редактировать участника',
			'view_item' => 'Посмотреть участника',
			'all_items' => 'Вся команда',
			'search_items' => 'Поиск по команде',
			'not_found' => 'Участники не найдены',
			'not_found_in_trash' => 'Участники не найдены в корзине',
		),

		'public' => true,
		'public_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,

		'rewrite' => array(
			'slug' => 'team',
			'with_front' => false,
			'pages' => true,
			'feeds' => true,
		),

		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => true,
		'menu_icon' => 'dashicons-nametag',
		'menu_position' => 3,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'custom-fields',
			'page-attributes',
		),

		'show_in_rest' => false
	));
});


add_action('init', function () {
	register_post_type('services', array(
		'labels' => array(
			'name' => 'Услуги',
			'singular_name' => 'Услуга',
			'menu_name' => 'Услуги',
			'name_admin_bar' => 'Услуга',
			'add_new' => 'Добавить услугу',
			'add_new_item' => 'Добавить новую услугу',
			'new_item' => 'Новая услуга',
			'edit_item' => 'Редактировать услугу',
			'view_item' => 'Посмотреть услугу',
			'all_items' => 'Все услуги',
			'search_items' => 'Поиск услуг',
			'not_found' => 'Услуги не найдены',
			'not_found_in_trash' => 'Услуги не найдены в корзине',
		),
		'menu_icon' => 'dashicons-hammer',
		'public' => true,
		'public_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,

		'rewrite' => array(
			'slug' => 'services',
			'with_front' => false,
			'pages' => true,
			'feeds' => true,
		),

		'capability_type' => 'post',
		'has_archive' => true,
		'hierarchical' => true,
		'menu_position' => 3,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			'excerpt',
			'custom-fields',
			'page-attributes',
		),

		'show_in_rest' => false
	));
});

// таксономия для услуг
register_taxonomy('services_category', ['services'], [
	'labels' => [
		'name' => 'Категории услуг',
		'singular_name' => 'Категория услуг',
		'search_items' => 'Поиск категории',
		'all_items' => 'Все категории',
		'parent_item' => 'Родительская категория',
		'parent_item_colon' => 'Родительская категория:',
		'edit_item' => 'Редактировать категорию',
		'update_item' => 'Обновить категорию',
		'add_new_item' => 'Добавить новую категорию',
		'new_item_name' => 'Название новой категории',
		'menu_name' => 'Категории',
		'back_to_items' => '← Назад к категориям',
	],
	'description' => '',
	'public' => true,
	'hierarchical' => true,
	'rewrite' => array('slug' => 'services_category'),
	'show_admin_column' => false,
	'show_in_rest' => false,
]);

