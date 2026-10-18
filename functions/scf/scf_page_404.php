<?php
create_options_page(
	'Страница 404',
	'opt-page-404',
);

create_fields(
	'Поля - Страница 404',
	'opt-page-404',
	[
		add_field_redactor_wysiwyg(
			'page_404_title',
			'Заголовок'
		),
		add_field_redactor_wysiwyg(
			'page_404_descr',
			'Описание'
		),
		add_field_link(
			'page_404_btn',
			'Кнопка'
		),
	]
);