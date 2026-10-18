<?php
add_action('acf/init', function () {

	acf_add_local_field_group(array(
		'key' => 'group_single_blog_grid',
		'title' => 'Первый экран: дополнительные поля',
		'fields' => array(
			array(
				'key' => 'field_single_blog_grid',
				'name' => 'single_blog_grid',
				'label' => 'Контент блок',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить блок',
				'sub_fields' => array(
					array(
						'key' => 'field_single_blog_grid_toggle',
						'name' => 'toggle',
						'label' => 'Галерея справа',
						'type' => 'true_false',
						'instructions' => '',
						'required' => 0,
						'default_value' => 0,
						'ui' => 1,
						'ui_on_text' => 'Да',
						'ui_off_text' => 'Нет',
					),
					array(
						'key' => 'field_single_blog_grid_gallery',
						'name' => 'gallery',
						'label' => 'Галерея',
						'type' => 'gallery',
					),
					array(
						'key' => 'field_single_blog_grid_descr',
						'name' => 'descr',
						'label' => 'Текстовый контент',
						'type' => 'wysiwyg',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'template-single-blog.php',
				),
			),
		),
	));
});
?>