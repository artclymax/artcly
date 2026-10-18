<?php

create_fields(
	'Первый экран',
	'services',
	[
		add_field_tab(
			'services_tab_hero',
			'Первый экран',
		),
		add_field_redactor_wysiwyg(
			'services_hero_title',
			'Заголовок',
		),
		add_field_redactor_wysiwyg(
			'services_hero_descr',
			'Описание',
		),
		add_field_tab(
			'services_tab_form',
			'Форма',
		),
		add_field_text(
			'services_hero_form_title',
			'Заголовок формы',
			'*по-умолчанию будет текст: Получите бесплатный аудит'
		),
		add_field_redactor_wysiwyg(
			'services_hero_form_descr',
			'Описание формы',
			'*по-умолчанию будет текст: Введите ваше имя и телефон и мы свяжемся с вами в ближайшее время'
		),
	],
	'post_type'
);


add_action('acf/init', function () {

	// hero
	acf_add_local_field_group(array(
		'key' => 'group_hero_additional',
		'title' => 'Первый экран: дополнительные поля',
		'fields' => array(
			array(
				'key' => 'services_hero_add_tab_decor',
				'name' => 'services_hero_add_tab_decor',
				'label' => 'Декор-заметка',
				'type' => 'tab',
			),
			array(
				'key' => 'services_hero_add_note',
				'name' => 'services_hero_add_note',
				'label' => 'Декор-заметка',
				'type' => 'group',
				'sub_fields' => array(
					array(
						'key' => 'services_hero_add_note_title',
						'name' => 'services_hero_add_note_title',
						'label' => 'Заголовок',
						'type' => 'text',
					),
					array(
						'key' => 'services_hero_add_note_image',
						'name' => 'services_hero_add_note_image',
						'label' => 'Картинка',
						'type' => 'image',
					),
				)
			),
			array(
				'key' => 'services_hero_add_tab_list',
				'name' => 'services_hero_add_tab_list',
				'label' => 'Список',
				'type' => 'tab',
			),
			array(
				'key' => 'services_hero_add_list',
				'name' => 'services_hero_add_list',
				'label' => 'Список',
				'type' => 'repeater',
				'sub_fields' => array(
					array(
						'key' => 'services_hero_add_list_image',
						'name' => 'services_hero_add_list_image',
						'label' => 'Картинка',
						'type' => 'image',
					),
					array(
						'key' => 'services_hero_add_list_title',
						'name' => 'services_hero_add_list_title',
						'label' => 'Заголовок',
						'type' => 'text',
					)
				)
			),
			array(
				'key' => 'services_hero_add_tab_btn',
				'name' => 'services_hero_add_tab_btn',
				'label' => 'Кнопки',
				'type' => 'tab',
			),
			array(
				'key' => 'services_hero_add_btn_first',
				'name' => 'services_hero_add_btn_first',
				'label' => 'Кнопка первая',
				'type' => 'link',
			),
			array(
				'key' => 'services_hero_add_btn_second',
				'name' => 'services_hero_add_btn_second',
				'label' => 'Кнопка вторая',
				'type' => 'link',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'template-single-services-sites.php',
				),
			),
		),
	));
	// Услуги — Риски
	acf_add_local_field_group(array(
		'key' => 'group_risks_second_block',
		'title' => 'Риски (Вторая версия)',
		'fields' => array(
			array(
				'key' => 'field_risks_second_tab_content',
				'name' => 'risks_second_tab_content',
				'label' => 'Основной контент',
				'type' => 'tab',
			),
			// 1. Заголовок
			array(
				'key' => 'field_risks_second_title',
				'name' => 'risks_second_title',
				'label' => 'Заголовок секции',
				'type' => 'wysiwyg',
			),

			// 2. Описание
			array(
				'key' => 'field_risks_second_descr',
				'name' => 'risks_second_descr',
				'label' => 'Описание',
				'type' => 'wysiwyg',
			),

			// 3. Картинка (слева/справа)
			array(
				'key' => 'field_risks_second_image',
				'name' => 'risks_second_image',
				'label' => 'Изображение',
				'type' => 'image',
			),
			// 7. Кнопка
			array(
				'key' => 'field_risks_second_btn',
				'name' => 'risks_second_btn',
				'label' => 'Кнопка',
				'type' => 'link',
				'return_format' => 'array',
			),
			// 4. Список (основной список рисков)
			array(
				'key' => 'field_risks_second_list',
				'name' => 'risks_second_list',
				'label' => 'Список рисков',
				'type' => 'repeater',
				'instructions' => 'Добавьте пункты списка',
				'layout' => 'table',
				'button_label' => 'Добавить пункт',
				'collapsed' => 'risks_list_text',
				'sub_fields' => array(
					array(
						'key' => 'field_risks_list_title',
						'name' => 'risks_list_title',
						'label' => 'Заголовок',
						'type' => 'text',
					),
					array(
						'key' => 'field_risks_list_text',
						'name' => 'risks_list_text',
						'label' => 'Текст пункта',
						'type' => 'text',
					),
				),
			),
			array(
				'key' => 'field_risks_second_tab_bad',
				'name' => 'risks_second_tab_bad',
				'label' => 'Неправильный путь',
				'type' => 'tab',
			),
			// 5. "Неправильный путь" (Список Bad)
			array(
				'key' => 'field_risks_second_bad',
				'name' => 'risks_second_bad',
				'label' => 'Список: Неправильный путь',
				'type' => 'repeater',
				'instructions' => 'Пункты, чего делать НЕ стоит',
				'layout' => 'table',
				'button_label' => 'Добавить пункт',
				'sub_fields' => array(
					array(
						'key' => 'field_risks_bad_list_text',
						'name' => 'risks_bad_list_text',
						'label' => 'Текст пункта',
						'type' => 'text',
						'parent' => 'field_risks_second_bad',
					),
				),
			),
			array(
				'key' => 'field_risks_second_tab_good',
				'name' => 'risks_second_tab_good',
				'label' => 'Правильный путь',
				'type' => 'tab',
			),
			// 6. "Правильный путь" (Список Good)
			array(
				'key' => 'field_risks_second_good',
				'name' => 'risks_second_good',
				'label' => 'Список: Правильный путь',
				'type' => 'repeater',
				'instructions' => 'Пункты, как делать ПРАВИЛЬНО',
				'layout' => 'table',
				'button_label' => 'Добавить пункт',
				'sub_fields' => array(
					array(
						'key' => 'field_risks_good_list_text',
						'name' => 'risks_good_list_text',
						'label' => 'Текст пункта',
						'type' => 'text',
						'parent' => 'field_risks_second_good',
					),
				),
			),



		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-single-services-sites.php',
				),
			),
		),
	));

	acf_add_local_field_group(array(
		'key' => 'group_services_features',
		'title' => 'Услуги: Наш подход 2',
		'fields' => array(

			// 1. Заголовок секции
			array(
				'key' => 'field_services_features_title',
				'name' => 'services_features_title',
				'label' => 'Заголовок секции',
				'type' => 'wysiwyg',
			),

			// 2. Описание секции
			array(
				'key' => 'field_services_features_descr',
				'name' => 'services_features_descr',
				'label' => 'Описание',
				'type' => 'wysiwyg',
			),

			// 3. Repeater: Список преимуществ/этапов
			array(
				'key' => 'field_services_features_list',
				'name' => 'services_features_list',
				'label' => 'Элементы списка',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить элемент',
				'collapsed' => 'services_features_list_title',
				'sub_fields' => array(
					// 3.1 Изображение
					array(
						'key' => 'field_services_features_list_image',
						'name' => 'services_features_list_image',
						'label' => 'Изображение',
						'type' => 'image',
					),
					// 3.2 Заголовок элемента
					array(
						'key' => 'field_services_features_list_title',
						'name' => 'services_features_list_title',
						'label' => 'Заголовок элемента',
						'type' => 'text',
					),
					// 3.3 Описание элемента
					array(
						'key' => 'field_services_features_list_descr',
						'name' => 'services_features_list_descr',
						'label' => 'Описание элемента',
						'type' => 'wysiwyg',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-single-services-sites.php',
				),
			),
		),
	));

	acf_add_local_field_group(array(
		'key' => 'group_cta_second_section',
		'title' => 'Услуги: CTA Форма (Вторая)',
		'fields' => array(

			// Заголовок
			array(
				'key' => 'field_section_form_second_cta_title',
				'name' => 'section_form_second_cta_title',
				'label' => 'Заголовок CTA',
				'type' => 'wysiwyg',
			),

			// Шорткод формы
			array(
				'key' => 'field_section_form_second_cta_form',
				'name' => 'section_form_second_cta_form',
				'label' => 'Шорткод формы',
				'type' => 'text',
				'placeholder' => '[contact-form-7 id="123"] или [gravityform id="1"]',
				'instructions' => 'Вставьте шорткод формы. Секция отобразится только если это поле заполнено.',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-single-services-sites.php',
				),
			),
		),
	));

	acf_add_local_field_group(array(
		'key' => 'group_type_of_services',
		'title' => 'Секция: Виды услуг',
		'fields' => array(

			// 1. Заголовок секции
			array(
				'key' => 'field_type_of_services_title',
				'name' => 'type_of_services_title',
				'label' => 'Заголовок секции',
				'type' => 'wysiwyg',
			),
			// 3. Общая кнопка под списком
			array(
				'key' => 'field_type_of_services_btn',
				'name' => 'type_of_services_btn',
				'label' => 'Общая кнопка (под списком)',
				'type' => 'link',
			),
			// 2. Repeater: Карточки услуг
			array(
				'key' => 'field_type_of_services_list',
				'name' => 'type_of_services_list',
				'label' => 'Список услуг',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить услугу',
				'collapsed' => 'type_of_services_list_title',
				'sub_fields' => array(
					// Картинка карточки
					array(
						'key' => 'field_type_of_services_list_image',
						'name' => 'type_of_services_list_image',
						'label' => 'Изображение',
						'type' => 'image',
					),
					// Заголовок карточки
					array(
						'key' => 'field_type_of_services_list_title',
						'name' => 'type_of_services_list_title',
						'label' => 'Заголовок услуги',
						'type' => 'text',
					),
					// Описание карточки
					array(
						'key' => 'field_type_of_services_list_descr',
						'name' => 'type_of_services_list_descr',
						'label' => 'Описание услуги',
						'type' => 'textarea',
						'rows' => 3,
						'new_lines' => 'wpautop',
					),
					array(
						'key' => 'field_type_of_services_list_link',
						'name' => 'type_of_services_list_link',
						'label' => 'Ссылка',
						'type' => 'link',
					),
				),
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-single-services-sites.php',
				),
			),
		),
	));

	acf_add_local_field_group(array(
		'key' => 'group_services_results_form',
		'title' => 'Секция: Результат с формой',
		'fields' => array(

			array(
				'key' => 'field_services_results_form_title',
				'name' => 'services_results_form_title',
				'label' => 'Заголовок секции',
				'type' => 'wysiwyg',
				'placeholder' => 'Результат внедрения системы',
			),

			array(
				'key' => 'field_services_results_form_list',
				'name' => 'services_results_form_list',
				'label' => 'Список преимуществ / Контент',
				'type' => 'wysiwyg',
			),

			array(
				'key' => 'field_services_results_form_image',
				'name' => 'services_results_form_image',
				'label' => 'Изображение',
				'type' => 'image',
			),

			array(
				'key' => 'field_services_results_form_title_form',
				'name' => 'services_results_form_title_form',
				'label' => 'Заголовок формы',
				'type' => 'text',
			),

			array(
				'key' => 'field_services_results_form_form',
				'name' => 'services_results_form_form',
				'label' => 'Шорткод формы',
				'type' => 'text',
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-single-services-sites.php',
				),
			),
		),
	));

	acf_add_local_field_group(array(
		'key' => 'group_services_process_deadlines',
		'title' => 'Секция: Сроки и Этапы',
		'fields' => array(

			array(
				'key' => 'field_services_process_deadlines_title',
				'name' => 'services_process_deadlines_title',
				'label' => 'Заголовок секции',
				'type' => 'wysiwyg',
			),

			array(
				'key' => 'field_services_process_deadlines_descr',
				'name' => 'services_process_deadlines_descr',
				'label' => 'Описание',
				'type' => 'wysiwyg',
			),

			array(
				'key' => 'field_services_process_deadlines_list',
				'name' => 'services_process_deadlines_list',
				'label' => 'Список этапов',
				'type' => 'repeater',
				'layout' => 'table',
				'button_label' => 'Добавить этап',
				'sub_fields' => array(
					array(
						'key' => 'field_services_process_deadlines_list_text',
						'name' => 'services_process_deadlines_list_text',
						'label' => 'Текст этапа',
						'type' => 'text',
					),
				),
			),

			array(
				'key' => 'field_services_process_deadlines_note',
				'name' => 'services_process_deadlines_note',
				'label' => 'Примечание',
				'type' => 'group',
				'sub_fields' => array(
					array(
						'key' => 'field_services_process_deadlines_note_title',
						'name' => 'services_process_deadlines_note_title',
						'label' => 'Заголовок примечания',
						'type' => 'text',
					),
					array(
						'key' => 'field_services_process_deadlines_note_image',
						'name' => 'services_process_deadlines_note_image',
						'label' => 'Изображение',
						'type' => 'image',
					),
					array(
						'key' => 'field_services_process_deadlines_note_text',
						'name' => 'services_process_deadlines_note_text',
						'label' => 'Текст примечания',
						'type' => 'text',
					),
				),
			),

			array(
				'key' => 'field_services_process_deadlines_btn',
				'name' => 'services_process_deadlines_btn',
				'label' => 'Кнопка',
				'type' => 'link',
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'template-single-services-sites.php',
				),
			),
		),
	));
});