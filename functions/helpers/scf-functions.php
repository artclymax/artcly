<?php
// ! Кнопки свернуть и развернуть повторитель
add_action('acf/input/admin_head', 'add_acf_collapse_buttons');
function add_acf_collapse_buttons()
{
	?>
		<script type="text/javascript">
			(function ($) {
				// Добавляем кнопки сворачивания
				acf.addAction('ready', function () {
					$('.acf-field-repeater').each(function () {
						var $field = $(this);
						var $label = $field.find('> .acf-label');
						var $repeater = $field.find('> .acf-input > .acf-repeater');

						// Проверяем, не добавлены ли уже кнопки
						if ($label.find('.acf-repeater-controls').length === 0) {
							// Создаем контейнер для кнопок
							var $controls = $('<div class="acf-repeater-controls"></div>');

							// Добавляем кнопки
							$controls.append('<a href="#" class="button button-small acf-expand-all">Развернуть все</a> ');
							$controls.append('<a href="#" class="button button-small acf-collapse-all">Свернуть все</a>');

							// Добавляем контейнер в label
							$label.append($controls);
						}
					});

					// Обработчик для сворачивания
					$(document).on('click', '.acf-collapse-all', function (e) {
						e.preventDefault();
						$(this).closest('.acf-field-repeater').find('.acf-row:not(.acf-clone)').addClass('-collapsed');
					});

					// Обработчик для разворачивания
					$(document).on('click', '.acf-expand-all', function (e) {
						e.preventDefault();
						$(this).closest('.acf-field-repeater').find('.acf-row:not(.acf-clone)').removeClass('-collapsed');
					});
				});
			})(jQuery);
		</script>
		<style>
			.acf-repeater-controls {
				display: inline-block;
				margin-right: 10px;
				vertical-align: middle;
			}

			.acf-repeater-controls .button {
				margin-right: 5px;
			}

			.acf-label>label {
				display: inline-block;
				vertical-align: middle;
			}
		</style>
		<?php
}

/**
 * create_options_page() — helper для ACF / SCF options pages
 *
 * Сигнатура:
 * create_options_page(
 *   string $page_title, // Заголовок страницы (и пункт меню)
 *   string $slug,       // Уникальный menu_slug (используется в location)
 *   array  $args = []   // Доп. аргументы ACF (необязательно)
 * );
 *
 * Минимальный пример:
 *
 * create_options_page('Настройки сайта', 'site-settings');
 *
 * Пример с доп. параметрами:
 *
 * create_options_page(
 *   'Хедер',
 *   'header-settings',
 *   [
 *     'menu_title' => 'Хедер',
 *     'parent_slug' => 'site-settings', // сделать дочерней страницей
 *     'capability' => 'manage_options',
 *     'position' => 20,
 *     'icon_url' => 'dashicons-admin-generic',
 *   ]
 * );
 *
 * Как привязать поля к options page:
 *
 * create_fields(
 *   'Поля хедера',
 *   'header-settings', // <-- menu_slug
 *   $fields
 * );
 *
 * Получение значений в шаблоне:
 *
 * get_field('field_name', 'option');
 * the_field('field_name', 'option');
 *
 * Важно:
 * - slug должен быть уникальным
 * - redirect = false → страница может иметь свои поля
 * - parent_slug позволяет строить иерархию меню
 */
function create_options_page(
	string $page_title,
	string $slug,
	?string $parent_slug = null,
	array $args = []
) {
	if (!function_exists('acf_add_options_page')) {
		return;
	}

	$defaults = [
		'page_title' => $page_title,
		'menu_title' => $page_title,
		'menu_slug' => $slug,
		'capability' => 'manage_options',
		'redirect' => false,
	];

	// если parent_slug передан — добавляем его в массив
	if ($parent_slug) {
		$defaults['parent_slug'] = $parent_slug;
	}

	acf_add_options_page(array_merge($defaults, $args));
}
/**
 * ACF / SCF location cheatsheet
 *
 * Привязка полей через create_fields():
 *
 * create_fields(
 *   $title,          // Заголовок группы полей в админке
 *   $location_value, // Значение условия (slug, ID, template)
 *   $fields,         // Массив полей ACF
 *   $location_param  // Тип привязки (см. ниже)
 * );
 *
 * Основные варианты $location_param:
 *
 * 'options_page'  => options page (value = menu_slug)
 * 'post_type'     => тип записи (value = 'post', 'page', 'cars')
 * 'page'          => конкретная страница (value = page ID)
 * 'post'          => конкретная запись (value = post ID)
 * 'page_template' => шаблон страницы (value = 'page-home.php')
 * 'taxonomy'      => таксономия (value = 'category', 'car_brand')
 * 'user_role'     => роль пользователя (value = 'administrator')
 *
 * Примеры:
 *
 * // Поля для options page
 * create_fields('Настройки сайта', 'site-settings', $fields);
 *
 * // Поля для всех записей CPT cars
 * create_fields('Автомобили', 'cars', $fields, 'post_type');
 *
 * // Поля для шаблона страницы
 * create_fields('Главная', 'page-home.php', $fields, 'page_template');
 *
 * // Поля для конкретной страницы
 * create_fields('Контакты', 42, $fields, 'page');
 */
function create_fields(
	string $title,
	string $location_value,
	array $fields,
	string $location_param = 'options_page',
	array $extra = []
) {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(array_merge([
		'key' => 'group_' . sanitize_title($location_value),
		'title' => $title,
		'fields' => $fields,
		'location' => [
			[
				[
					'param' => $location_param,
					'operator' => '==',
					'value' => $location_value,
				],
			],
		],
	], $extra));
}

/*
create_fields(
	 'Поля — Почему с нами удобно',
	 'opt-why',
	 [
		  add_field_text(
				'why_title',
				'Заголовок',
				'Основной заголовок блока',
				'Почему с нами удобно',
				true
		  ),
	 ]
);
*/
function add_field_text(
	string $name,
	string $label,
	?string $instructions = null,
	?string $default_value = null,
	bool $required = false,
	array $extra = []
): array {
	return array_merge([
		'key' => 'field_' . $name,
		'label' => $label,
		'name' => $name,
		'type' => 'text',
		'instructions' => $instructions ?? '',
		'default_value' => $default_value,
		'required' => $required ? 1 : 0,
	], $extra);
}
function add_field_textarea(
	string $name,
	string $label,
	?string $instructions = null,
	?string $default_value = null,
	bool $required = false,
	array $extra = []
): array {
	return array_merge([
		'key' => 'field_' . $name,
		'label' => $label,
		'name' => $name,
		'type' => 'textarea',
		'instructions' => $instructions ?? '',
		'default_value' => $default_value,
		'required' => $required ? 1 : 0,
		'rows' => 4,
	], $extra);
}
function add_field_toggle(
	string $name,
	string $label,
	?string $instructions = null,
	bool $default_value = false,
	array $extra = []
): array {
	return array_merge([
		'key' => 'field_' . $name,
		'label' => $label,
		'name' => $name,
		'type' => 'true_false',
		'instructions' => $instructions ?? '',
		'default_value' => $default_value ? 1 : 0,
		'ui' => 1,
	], $extra);
}
function add_field_image(
	string $name,
	string $label,
	?string $instructions = null,
	bool $required = false,
	array $extra = []
): array {
	return array_merge([
		'key' => 'field_' . $name,
		'label' => $label,
		'name' => $name,
		'type' => 'image',
		'instructions' => $instructions ?? '',
		'return_format' => 'array',
		'preview_size' => 'medium',
		'required' => $required ? 1 : 0,
	], $extra);
}
/*
add_field_repeater(
		'advantages',
		'Преимущества',
		[
				add_field_text('title', 'Заголовок'),
				add_field_textarea('text', 'Описание'),
		],
		null,
		[
				'collapse' => 'title',	 // <-- ключ sub-поля (name)
				'layout' => 'block',		 // <-- отображение
		]
);

*/
function add_field_repeater(
	string $name,
	string $label,
	array $sub_fields,
	?string $instructions = null,
	array $extra = []
): array {

	// layout: table | row | block
	$layout = $extra['layout'] ?? 'table';

	// collapse: null | 'sub_field_key'
	$collapse = $extra['collapse'] ?? null;

	// Удаляем из extra то, что мы уже использовали,
	// чтобы не дублировать в ACF массиве
	unset($extra['layout'], $extra['collapse']);

	return array_merge([
		'key' => 'field_' . $name,
		'label' => $label,
		'name' => $name,
		'type' => 'repeater',
		'instructions' => $instructions ?? '',
		'button_label' => 'Добавить',
		'layout' => $layout,
		'sub_fields' => $sub_fields,
		'collapsed' => $collapse,
	], $extra);
}


function add_field_redactor_wysiwyg(
	string $name,
	string $label,
	?string $instructions = null,
	?string $default_value = null,
	bool $required = false,
	array $extra = []
): array {
	return array_merge([
		'key' => 'field_' . $name,
		'label' => $label,
		'name' => $name,
		'type' => 'wysiwyg',
		'instructions' => $instructions ?? '',
		'default_value' => $default_value,
		'required' => $required ? 1 : 0,

		// настройки редактора
		'tabs' => 'all',          // all | visual | text
		'toolbar' => 'full',      // full | basic
		'media_upload' => 1,      // разрешить загрузку медиа
		'delay' => 0,             // инициализировать сразу
	], $extra);
}

function add_field_link(
	string $name,
	string $label,
	?string $instructions = null,
	bool $required = false,
	array $extra = []
): array {
	return array_merge([
		'key' => 'field_' . $name,
		'label' => $label,
		'name' => $name,
		'type' => 'link',
		'instructions' => $instructions ?? '',
		'required' => $required ? 1 : 0,
	], $extra);
}
function add_field_tab(
	string $name,
	string $label,
	array $extra = []
): array {
	return array_merge([
		'key' => 'field_' . $name,
		'label' => $label,
		'name' => $name,
		'type' => 'tab',
	], $extra);
}