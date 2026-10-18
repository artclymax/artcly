<?php
create_options_page(
	'Секции главной',
	'opt-main'
	,
);
create_options_page(
	'Сферы деятельности',
	'opt-specialties'
	,
	'opt-main',
);

create_fields(
	'Поля - Сферы деятельности',
	'opt-specialties',
	[
		add_field_redactor_wysiwyg(
			'specialties_title',
			'Заголовок',
		),
		add_field_repeater(
			'specialties_list',
			'Список',
			[
				add_field_text(
					'specialties_list_text',
					'Сфера'
				)
			],
		)
	]
);

// section-blog
create_options_page(
	'Статьи и полезная информация',
	'opt-section-blog'
	,
	'opt-main',
);

create_fields(
	'Поля - Статьи и полезная информация',
	'opt-section-blog',
	[
		add_field_redactor_wysiwyg(
			'section_blog_title',
			'Заголовок',
		),
		add_field_link(
			'section_blog_link',
			'Ссылка',
		)
	]
);
