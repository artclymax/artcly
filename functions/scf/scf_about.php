<?php
create_options_page(
	'Страница - О нас',
	'opt-page-about',
);

create_options_page(
	'Почему работать с нами выгоднее',
	'opt-about-benefits',
	'opt-page-about',
);

create_fields(
	'Поля - Почему работать с нами выгоднее',
	'opt-about-benefits',
	[
		add_field_redactor_wysiwyg(
			'about_benefits_title',
			'Заголовок'
		),
		add_field_repeater(
			'about_benefits_list',
			'Список',
			[
				add_field_image(
					'about_benefits_list_image',
					'Картинка'
				),
				add_field_text(
					'about_benefits_list_title',
					'Заголовок',
				),
				add_field_redactor_wysiwyg(
					'about_benefits_list_descr',
					'Описание'
				),
			]
		),
		add_field_image(
			'about_benefits_image',
			'Картинка',
		)
	]
);

create_options_page(
	'Наша команда',
	'opt-about-team',
	'opt-page-about',
);

create_fields(
	'Поля - Наша команда',
	'opt-about-team',
	[
		add_field_redactor_wysiwyg(
			'about_team_title',
			'Заголовок'
		),
		add_field_redactor_wysiwyg(
			'about_team_descr',
			'Описание'
		),
		add_field_image(
			'about_team_image_1',
			'Картинка 1',
		),
		add_field_image(
			'about_team_image_2',
			'Картинка 2',
		),
		add_field_image(
			'about_team_image_big',
			'Картинка большая',
		),
		add_field_redactor_wysiwyg(
			'about_team_slider_title',
			'Заголовок слайдера'
		),
	]
);

create_options_page(
	'Как мы превращаем маркетинг в систему роста:',
	'opt-about-steps',
	'opt-page-about',
);

create_fields(
	'Поля - Как мы превращаем маркетинг в систему роста:',
	'opt-about-steps',
	[
		add_field_redactor_wysiwyg(
			'about_steps_title',
			'Заголовок'
		),
		add_field_repeater(
			'about_steps_list',
			'Список',
			[
				add_field_text(
					'about_steps_list_text',
					'Текст'
				)
			]
		),
	]
);