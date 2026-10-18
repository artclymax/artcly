<?php

// === Helpers ===
require_once get_template_directory() . '/functions/helpers/print_dump.php';
require_once get_template_directory() . '/functions/helpers/mx_logo.php';
require_once get_template_directory() . '/functions/helpers/scf-functions.php';
//require_once get_template_directory() . '/functions/helpers/trim_text.php';
require_once get_template_directory() . '/functions/helpers/correct_phone.php';
require_once get_template_directory() . '/functions/helpers/add_admin_thumbnail_column.php';
//require_once get_template_directory() . '/functions/helpers/get_prev_post_slug.php';
//require_once get_template_directory() . '/functions/helpers/get_next_post_slug.php';
//require_once get_template_directory() . '/functions/helpers/custom_product_category.php';
//require_once get_template_directory() . '/functions/helpers/get_product_attributes_array.php';

// === BASE ====
// Общая настройка темы (лого, название и т.п.)
require_once get_template_directory() . '/functions/default_settings.php';

// Подключение стилей
require_once get_template_directory() . '/functions/connect_styles.php';

// Подключение скриптов
require_once get_template_directory() . '/functions/connect_scripts.php';

// Отключение стилей Woocommerce
//add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Поддержка темы на Woocommerce
//add_action('after_setup_theme', function () {
//	add_theme_support('woocommerce');
//});
// Создание меню
require_once get_template_directory() . '/functions/register_nav_menus.php';

// Регистрация новых записей
require_once get_template_directory() . '/functions/register_post_type.php';

// Кастомная админка
require_once get_template_directory() . '/functions/admin_page.php';


// Создание SCF-полей
require_once get_template_directory() . '/functions/scf_data.php';


//!
add_action('wp_head', function () {
	if (defined('WP_DEBUG')) {
		$vite_server = 'http://localhost:5173';
		echo "<!-- VITE DEV INJECT: start -->\n";
		echo '<script type="module" src="' . esc_url($vite_server) . '/@vite/client"></script>';
		echo '<script type="module" src="' . esc_url($vite_server) . '/main.js"></script>';
		echo "<!-- VITE DEV INJECT: end -->\n";
	};
});

add_filter('bcn_breadcrumb_title', function ($title, $type, $id) {

	// Главная страница
	if (in_array('home', $type)) {
		return 'Главная';
	}

	return $title;
}, 10, 3);


add_admin_thumbnail_column('projects');
add_admin_thumbnail_column('reviews');
add_admin_thumbnail_column('team');

add_action('pre_get_posts', function ($query) {
	// Проверяем: фронтенд, основной запрос, архив CPT "reviews"
	if (!is_admin() && $query->is_main_query() && is_post_type_archive('reviews')) {
		$query->set('posts_per_page', 12);
		$query->set('orderby', 'menu_order'); // если нужно сортировать по menu_order
		$query->set('order', 'ASC');
	}
});
add_action('pre_get_posts', function ($query) {
	// Проверяем: фронтенд, основной запрос, архив CPT "blog"
	if (!is_admin() && $query->is_main_query() && is_post_type_archive('blog')) {
		$query->set('posts_per_page', 12);
		$query->set('orderby', 'menu_order'); // если нужно сортировать по menu_order
		$query->set('order', 'ASC');
	}
});
add_action('pre_get_posts', function ($query) {
	// Проверяем: фронтенд, основной запрос, архив/таксономия CPT "services"
	if (!is_admin() && $query->is_main_query() && (is_post_type_archive('services') || is_tax('services_category'))) {
		$query->set('posts_per_page', 12);
	}
});
add_filter('big_image_size_threshold', '__return_false');

function custom_post_order($query)
{
	if ($query->is_main_query() && !is_admin()) {
		$query->set('orderby', 'ID');
		$query->set('order', 'ASC');
	}
}
add_action('pre_get_posts', 'custom_post_order');

// Перенос 'и' и других предлогов
function mx_fix_orphans($text)
{
	if (is_admin())
		return $text;
	if (!is_string($text))
		return $text;

	return preg_replace('/(\s|&nbsp;)([а-яА-Яa-zA-Z]{1,2})\s/u', '$1$2&nbsp;', $text); //return preg_replace('/\s([а-яА-Яa-zA-Z]{1,2})\s/u', ' $1&nbsp;', $text);
}
// ACF
add_filter('acf/format_value', 'mx_fix_orphans', 20);
add_filter('the_content', 'mx_fix_orphans', 20);
add_filter('the_title', 'mx_fix_orphans', 20);
add_filter('the_excerpt', 'mx_fix_orphans', 20);
add_filter('nav_menu_item_title', 'mx_fix_orphans', 20);

//!==========
require_once get_template_directory() . '/functions/form-sender/form-sender.php';

function mx_form($btn = "Отправить заявку")
{
	$messengers = [
		[
			'id' => 'whatsapp',
			'name' => 'Ватсап',
			'image' => get_template_directory_uri() . '/assets/images/icons/wh.svg'
		],
		[
			'id' => 'viber',
			'name' => 'Вайбер',
			'image' => get_template_directory_uri() . '/assets/images/icons/vb.svg'
		],
		[
			'id' => 'telegram',
			'name' => 'Телеграм',
			'image' => get_template_directory_uri() . '/assets/images/icons/tg.svg'
		],
		[
			'id' => 'phone',
			'name' => 'Телефон',
			'image' => get_template_directory_uri() . '/assets/images/icons/phone-icon.svg'
		],
	]
		?>
	<form class="wcf-form" method="post" data-form-id="mxform_callback">
		<div class="form-wrapper">
			<?php wcf_form_fields('mxform_callback'); ?>
			<div class="form-field">
				<input class="form-input" type="text" name="name" placeholder="Ваше имя">
			</div>
			<div class="form-field" data-required-field="Введите номер телефона">
				<input class="form-input" type="tel" name="phone" data-required placeholder="+375 (__) ___-__-__">
			</div>
			<div class="form-box">
				<p class="text-second">
					Укажите удобный способ связи:
				</p>
				<div class="form-box__checkboxes">
					<?php
					if ($messengers) {
						foreach ($messengers as $item) {
							?>
							<div class="form-checkbox">
								<label class="form-checkbox__label" title="<?= esc_attr($item['name']); ?>">
									<input class="form-checkbox__input" type="checkbox" name="msg_<?= esc_attr($item['id']); ?>"
										id="<?= esc_attr($item['id']); ?>" value="да">
									<span>
										<img src="<?= esc_attr($item['image']); ?>" alt="<?= esc_attr($item['name']); ?>">
									</span>
								</label>
							</div>
							<?php
						}
					}
					?>
				</div>
			</div>
			<div class="form-field" data-required-field="Необходимо согласие на обработку данных">
				<label class="form-acceptance">
					<input class="form-acceptance__input" type="checkbox" name="accept" data-required checked value="да">
					<span class="form-acceptance__checkbox"></span>
					<span class="form-acceptance__text">Даю свое согласие на <a
							href="<?= esc_url(home_url('/policy/')); ?>">обработку персональных данных</a></span>
				</label>
			</div>
			<button class="btn" type="submit"><?= esc_html($btn); ?></button>
		</div>
	</form>
	<?php
}
;
