<?php
create_options_page(
	'Страница благодарности',
	'opt-thank-you',
);

create_fields(
	'Поля - Страница благодарности',
	'opt-thank-you',
	[
		add_field_redactor_wysiwyg(
			'thank_you_title',
			'Заголовок'
		),
		add_field_redactor_wysiwyg(
			'thank_you_descr',
			'Описание'
		),
		add_field_link(
			'thank_you_btn_home',
			'Кнопка первая'
		),
		add_field_link(
			'thank_you_btn_form',
			'Кнопка вторая'
		),
		add_field_image(
			'thank_you_image',
			'Фон'
		),
	]
);