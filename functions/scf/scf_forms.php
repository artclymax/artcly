<?php
// section-form
create_options_page(
	'Формы',
	'opt-section-form'
);

create_fields(
	'Поля - Формы:',
	'opt-section-form',
	[
		add_field_tab(
			'section_form_tab',
			'Форма большая (на Главной)'
		),
		add_field_redactor_wysiwyg(
			'section_form_title',
			'Заголовок',
		),
		add_field_redactor_wysiwyg(
			'section_form_descr',
			'Описание',
		),
		add_field_tab(
			'section_form_cta_tab',
			'Форма маленькая'
		),
		add_field_redactor_wysiwyg(
			'section_form_cta_title',
			'Заголовок',
		),
	]
);
?>