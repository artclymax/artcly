<?php
function my_admin_sections(): array
{
	return [

		'Основные секции' => [
			'opened' => true,
			'pages' => [
				'opt-contacts',
				'opt-header',
				'opt-footer',
				'opt-section-form',
				'opt-modal',
				'opt-thank-you',
				'opt-page-404',
			],
		],

		'Главная страница' => [
			'pages' => [
				'opt-home-hero',
				'opt-complex-marketing',
				'opt-services',
				'opt-process',
				'opt-results',
				'opt-section-projects',
				'opt-section-reviews',
				'opt-section-about',
				'opt-specialties',
				'opt-section-blog',
			],
		],

		'О компании' => [
			'pages' => [
				'opt-section-about',
				'opt-about-benefits',
				'opt-about-team',
				'opt-about-steps',
			],
		],

		'Контакты' => [
			'pages' => [
				'opt-contacts',
			],
		],

	];
}

function is_acf_active()
{
	return function_exists('acf_get_options_pages');
}

function is_flamingo_active()
{
	return post_type_exists('flamingo_inbound');
}

add_action('admin_menu', function () {
	add_menu_page(
		'Настройки сайта',
		'Настройки сайта',
		'manage_options',
		'custom-site-settings',
		'render_custom_site_settings',
		'dashicons-admin-settings',
		1
	);
});

add_action('admin_init', function () {
	register_setting('custom_site_settings', 'blogname');
	register_setting('custom_site_settings', 'blogdescription');
	register_setting('custom_site_settings', 'site_icon');
});

add_action('admin_init', function () {

	if (
		!isset($_POST['option_page']) ||
		$_POST['option_page'] !== 'custom_site_settings'
	) {
		return;
	}

	if (!current_user_can('manage_options')) {
		return;
	}

	if (isset($_POST['custom_logo'])) {
		set_theme_mod('custom_logo', absint($_POST['custom_logo']));
	}
});
function render_custom_site_settings()
{
	?>
	<div class="wrap custom-admin">
		<style>
			.custom-admin__wrapper {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				gap: 20px;
				margin-top: 20px;
			}

			.custom-admin__wrapper .card {
				margin: 0;
				width: 100%;
				max-width: 100%;
				padding: 1em;
			}

			.adm-social {
				display: flex;
				gap: 10px;
			}

			.adm-social a {
				text-decoration: none;
			}

			.custom-admin__wrapper input:not(type="submit") {
				width: 100%;
			}

			.custom-admin__wrapper table {
				width: 100%;
			}

			@media screen(max-width: 1250px) {
				.custom-admin__wrapper {
					grid-template-columns: 1fr;
				}
			}

			.custom-admin details {
				border: 1px solid #dcdcde;
				border-radius: 4px;
				background: #fff;
				margin-bottom: 12px;
			}

			.custom-admin details summary {
				padding: 12px 16px;
				font-size: 15px;
				font-weight: 600;
				cursor: pointer;
				list-style: none;
				position: relative;
			}

			.custom-admin details summary::-webkit-details-marker {
				display: none;
			}

			.custom-admin details summary::after {
				content: "▸";
				position: absolute;
				right: 16px;
				transition: transform .2s ease;
			}

			.custom-admin details[open] summary::after {
				transform: rotate(90deg);
			}

			.custom-admin details .details-inner {
				padding: 12px 16px 16px;
				border-top: 1px solid #dcdcde;
			}
		</style>
		<h1>Настройки сайта</h1>

		<?php settings_fields('custom_site_settings'); ?>
		<div class="custom-admin__wrapper">
			<?php render_main_settings_section(); ?>
			<?php render_pages_section(); ?>
			<?php if (is_flamingo_active()) {
				render_flamingo_block();
			} ?>
			<?php render_support_block(); ?>
		</div>
	</div>
	<?php
}
add_action('in_admin_header', function () {

	if (
		isset($_GET['page']) &&
		$_GET['page'] === 'custom-site-settings'
	) {
		return;
	}

	$url = admin_url('admin.php?page=custom-site-settings');
	?>
	<div class="notice notice-warning" style="padding:0;margin:0 0 12px;">
		<a href="<?= esc_url($url); ?>" style="
			display:block;
			padding:12px 16px;
			text-decoration:none;
			color:inherit;">
			<h3 style="margin:0 0 4px;">⚙️ Настройки сайта</h3>
			<p style="margin:0 0 8px;">Перейдите в настройки сайта для управления основными параметрами</p>
			<span class="button button-primary">Перейти</span>
		</a>
	</div>
	<?php
});
add_action('admin_bar_menu', function ($wp_admin_bar) {

	if (!current_user_can('manage_options')) {
		return;
	}

	$wp_admin_bar->add_node([
		'id' => 'custom_site_settings',
		'title' => '⚙️ Настройки сайта',
		'href' => admin_url('admin.php?page=custom-site-settings'),
		'meta' => [
			'title' => 'Перейти к настройкам сайта',
		],
	]);

}, 100);
function render_main_settings_section()
{

	$logo_id = get_theme_mod('custom_logo');
	$icon_id = get_option('site_icon');
	?>
	<div class="card">
		<h2 class="title">Основные настройки</h2>
		<p class="description">Название, описание, логотип и системные параметры сайта.</p>
		<form method="post" action="options.php">
			<?php settings_fields('custom_site_settings'); ?>

			<table class="form-table" role="presentation">
				<tr>
					<th scope="row">
						<label for="admin_email">Email администратора</label>
					</th>
					<td>
						<p>
							<strong>
								<?= esc_html(get_option('admin_email')); ?>
							</strong>
						</p>

						<a href="<?= esc_url(admin_url('options-general.php#admin_email')); ?>" class="button button-secondary">
							Изменить Административный Email
						</a>

						<p class="description">
							На этот email приходят системные уведомления сайта и заявки с форм.
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label for="blogname">Название сайта</label>
					</th>
					<td>
						<input type="text" id="blogname" name="blogname" value="<?= esc_attr(get_option('blogname')); ?>"
							class="regular-text">
						<p class="description">Используется на вкладке браузера и вместо логотипа (если логотип не задан)</p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="blogdescription">Описание сайта</label>
					</th>
					<td>
						<textarea id="blogdescription" name="blogdescription" rows="3"
							class="large-text"><?= esc_textarea(get_option('blogdescription')); ?></textarea>
						<p class="description">Используется в meta description</p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="logo-preview">Логотип сайта</label>
					</th>
					<td>
						<p class="description">Если не задан, то будет использоваться название сайта</p>
						<img id="logo-preview" src="<?= $logo_id ? wp_get_attachment_image_url($logo_id, 'medium') : ''; ?>"
							style="max-width:160px; display:block; margin-bottom:10px;">

						<input type="hidden" name="custom_logo" id="custom_logo" value="<?= esc_attr($logo_id); ?>">

						<button class="button upload-logo">Выбрать логотип</button>
						<button class="button remove-logo">Удалить</button>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="logo-preview">Иконка сайта</label>
					</th>
					<td>
						<p class="description">Отображается на вкладке браузера</p>
						<img id="icon-preview" src="<?= $icon_id ? wp_get_attachment_image_url($icon_id, 'thumbnail') : ''; ?>"
							style="margin-bottom:10px;">

						<input type="hidden" name="site_icon" id="site_icon" value="<?= esc_attr($icon_id); ?>">
						<br>
						<button class="button upload-icon">Выбрать иконку</button>
					</td>
				</tr>

			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

add_action('admin_enqueue_scripts', function () {
	wp_enqueue_media();
});
add_action('admin_footer', function () {
	?>
	<script>
		jQuery(function ($) {

			function uploader(btn, input, preview) {
				let frame;
				btn.on('click', function (e) {
					e.preventDefault();

					frame = wp.media({
						title: 'Выбор изображения',
						multiple: false
					});

					frame.on('select', function () {
						const file = frame.state().get('selection').first().toJSON();
						input.val(file.id);
						preview.attr('src', file.url);
					});

					frame.open();
				});
			}

			uploader($('.upload-logo'), $('#custom_logo'), $('#logo-preview'));
			uploader($('.upload-icon'), $('#site_icon'), $('#icon-preview'));

			$('.remove-logo').on('click', function (e) {
				e.preventDefault();
				$('#custom_logo').val('');
				$('#logo-preview').attr('src', '');
			});

		});
	</script>
	<?php
});
//! === SECTIONS
function render_options_section(string $title, array $pages, bool $opened = false): void
{
	if (!is_acf_active()) {
		return;
	}
	?>
	<details <?= $opened ? 'open' : ''; ?>>
		<summary><?= esc_html($title); ?></summary>

		<div class="details-inner">
			<table class="widefat striped">
				<tbody>
					<?php foreach ($pages as $page_id): ?>
						<?php
						$page = acf_get_options_page($page_id);
						if (!$page) {
							continue;
						}

						$page_title = $page['page_title']
							?? $page['menu_title']
							?? $page_id;

						$edit_link = admin_url('admin.php?page=' . $page_id);
						?>
						<tr>
							<td>
								<a href="<?= esc_url($edit_link); ?>">
									<?= esc_html($page_title); ?>
								</a>
							</td>
							<td style="width:160px;">
								<a class="button button-small" href="<?= esc_url($edit_link); ?>">
									Редактировать
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</details>
	<?php
}
function render_data_spoiler(string $title, callable $content, bool $opened = false): void
{
	?>
	<details class="adm-spoiler" <?= $opened ? 'open' : ''; ?>>
		<summary><?= esc_html($title); ?></summary>
		<div class="details-inner">
			<?php $content(); ?>
		</div>
	</details>
	<?php
}
function render_pages_section()
{
	$pages = get_pages();
	$custom_posts = ['projects'];
	$sections = my_admin_sections();
	?>
	<div class="card">
		<h2 class="title">Редактирование контента сайта</h2>
		<p class="description">Все страницы, секции и записи сайта с быстрым доступом.</p>

		<?php
		foreach ($sections as $title => $config) {

			$pages_ids = $config['pages'] ?? [];
			$opened = $config['opened'] ?? false;

			render_options_section($title, $pages_ids, $opened);
		}
		?>

		<hr style="margin:20px 0;">

		<?php
		$menus = wp_get_nav_menus();
		?>

		<h3>Меню сайта</h3>

		<div style="display:flex; align-items:center; justify-content: space-between; gap:10px; margin-bottom:10px;">
			<span class="description">Быстрый доступ к меню сайта</span>

			<a href="<?= esc_url(admin_url('nav-menus.php?action=edit&menu=0')); ?>" class="page-title-action">
				Создать меню
			</a>
		</div>

		<?php if ($menus): ?>
			<table class="widefat striped" style="margin-bottom:30px;">
				<tbody>
					<?php foreach ($menus as $menu): ?>
						<tr>
							<td>
								<a href="<?= esc_url(admin_url('nav-menus.php?action=edit&menu=' . $menu->term_id)); ?>">
									<?= esc_html($menu->name); ?>
								</a>
							</td>
							<td style="width:160px;">
								<a class="button button-small"
									href="<?= esc_url(admin_url('nav-menus.php?action=edit&menu=' . $menu->term_id)); ?>">
									Редактировать
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<p class="description">Меню пока не созданы</p>
		<?php endif; ?>
		<h3>Записи</h3>

		<?php
		$post_types = get_post_types(
			[
				'public' => true,
				'_builtin' => false, // исключаем post и page
			],
			'objects'
		);

		// можно исключить ненужные
		$excluded = [
			'flamingo_inbound',
			'flamingo_contact',
		];

		?>

		<?php if ($post_types): ?>
			<table class="widefat striped">
				<tbody>
					<?php foreach ($post_types as $post_type):

						if (in_array($post_type->name, $excluded)) {
							continue;
						}
						?>
						<tr>
							<td>
								<a href="<?= esc_url(admin_url('edit.php?post_type=' . $post_type->name)); ?>">
									<?= esc_html($post_type->labels->name); ?>
								</a>
							</td>
							<td style="width:200px;">
								<a class="button button-secondary button-small"
									href="<?= esc_url(admin_url('post-new.php?post_type=' . $post_type->name)); ?>">
									Добавить <?= esc_html(mb_strtolower($post_type->labels->singular_name)); ?>
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<p class="description">Кастомные типы записей не найдены</p>
		<?php endif; ?>

		<h3>Страницы</h3>

		<table class="widefat striped" style="margin-bottom:30px;">
			<tbody>
				<?php foreach ($pages as $page): ?>
					<tr>
						<td>
							<a href="<?= get_permalink($page->ID); ?>" target="_blank">
								<?= esc_html($page->post_title); ?>
							</a>
						</td>
						<td style="width:160px;">
							<a class="button button-small" href="<?= get_edit_post_link($page->ID); ?>">
								Редактировать
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<?php
}
function render_flamingo_block()
{
	if (!post_type_exists('flamingo_inbound')) {
		return;
	}

	$leads = get_posts([
		'post_type' => 'flamingo_inbound',
		'posts_per_page' => 5,
		'post_status' => 'publish',
	]);
	?>
	<div class="card">

		<h2>Последние заявки</h2>
		<?php
		$admin_email = get_option('admin_email');
		?>

		<div class="" style="margin-bottom:10px;">
			<p>
				📬 <strong>Заявки с сайта будут приходить на email администратора:</strong>
				<code><?= esc_html($admin_email); ?></code>
				<a href="<?= esc_url(admin_url('options-general.php#admin_email')); ?>" style="margin-left:10px;">
					Изменить email
				</a>
			</p>
		</div>
		<table class="widefat striped">
			<thead>
				<tr>
					<th>Дата</th>
					<th>Сообщение</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($leads): ?>
					<?php foreach ($leads as $lead): ?>

						<?php
						$view_url = admin_url(
							'admin.php?page=flamingo_inbound&post=' . $lead->ID . '&action=edit'
						);
						?>

						<tr>
							<td style="white-space:nowrap;">
								<a href="<?= esc_url($view_url); ?>">
									<?= esc_html(
										get_date_from_gmt(
											$lead->post_date_gmt,
											'd.m.Y H:i'
										)
									); ?>
								</a>
							</td>

							<td>
								<a href="<?= esc_url($view_url); ?>">
									<?= esc_html(
										wp_trim_words(
											wp_strip_all_tags($lead->post_content),
											10,
											'…'
										)
									); ?>
								</a>
							</td>
						</tr>

					<?php endforeach; ?>
				<?php else: ?>
					<tr>
						<td colspan="2">Заявок пока нет</td>
					</tr>
				<?php endif; ?>
			</tbody>

		</table>

		<p style="margin-top:10px;">
			<a class="button" href="<?= esc_url(admin_url('admin.php?page=flamingo_inbound')); ?>">
				Все заявки
			</a>
		</p>
	</div>
	<?php
}


function render_support_block()
{
	?>
	<div class="card">
		<?php render_plugins_section(); ?>
		<div>
			<h2>Техническая информация</h2>
			<ul>
				<li>WordPress:
					<?php echo get_bloginfo('version'); ?>
				</li>
				<li>PHP:
					<?php echo phpversion(); ?>
				</li>
				<li>Тема:
					<?php echo wp_get_theme(); ?>
				</li>
			</ul>
		</div>

		<div>
			<h2>Поддержка</h2>
			<p>
				<a href="https://artcly.by/" target="_blank"><img
						src="https://cdn-ru.bitrix24.by/b18173214/bitrix24/4cd/4cdc51766a6144158d8d82e34051da16/logo_2I6sgS4a.png"
						alt="Веб студия"></a>
			</p>
			<p>
				E-mail: <a href="mailto:info@artcly.by" class="email">info@artcly.by</a>
			</p>
			<p>
				Телефон: <a href="tel:+375292389851" class="phone">
					+375 (29) 238-98-51 </a>
			</p>
			<p class="adm-social">
				<a href="viber://chat?number=%2B375292389851" class="social-icon">
					<img src="https://artcly.by/wp-content/themes/artcly_ready/image/Group 48100988.png" alt="Viber">
				</a>
				<a href="https://t.me/+375292389851" class="social-icon">
					<img src="https://artcly.by/wp-content/themes/artcly_ready/image/Group 48100987.png" alt="Telegram">
				</a>
				<a href="https://wa.me/375292389851" class="social-icon">
					<img src="https://artcly.by/wp-content/themes/artcly_ready/image/Group 48100986.png" alt="WhatsApp">
				</a>
			</p>
			<hr>
		</div>
	</div>

	<?php
}
function my_required_plugins()
{
	return [
		['slug' => 'cyr2lat', 'name' => 'Cyr-To-Lat'],
		['slug' => 'secure-custom-fields', 'name' => 'Secure Custom Fields'],
		//['slug' => 'show-current-template', 'name' => 'Show Current Template'],
		['slug' => 'contact-form-7', 'name' => 'Contact Form 7'],
		['slug' => 'breadcrumb-navxt', 'name' => 'Breadcrumb NavXT'],
		['slug' => 'flamingo', 'name' => 'Flamingo'],
		['slug' => 'safe-svg', 'name' => 'Safe SVG'],
		['slug' => 'wpcf7-redirect', 'name' => 'Redirection for Contact Form 7'],
		['slug' => 'wp-mail-smtp', 'name' => 'WP Mail SMTP от WPForms '],
	];
}
function render_plugins_section()
{
	$plugins = my_required_plugins();
	?>
	<div class="card">
		<h2 class="title">Рекомендуемые плагины</h2>
		<p class="description">Быстрая установка необходимых плагинов для проекта.</p>

		<?php
		require_once ABSPATH . 'wp-admin/includes/plugin.php';

		// 🔹 Форма "Установить все"
		?>
		<form method="post" action="<?php echo admin_url('admin-post.php'); ?>" style="margin-bottom:15px;">
			<input type="hidden" name="action" value="install_all_plugins">
			<?php wp_nonce_field('install_all_plugins'); ?>
			<button type="submit" class="button button-primary">Установить все отсутствующие</button>
		</form>

		<ul style="list-style:none; padding-left:0;">
			<?php foreach ($plugins as $plugin):
				$slug = $plugin['slug'];
				$installed_plugins = get_plugins("/{$slug}");

				if ($installed_plugins) {
					$status = '✅ Установлен';
					$button = '';
				} else {
					$status = '❌ Не установлен';
					// 🔹 Форма для установки одного плагина
					ob_start(); ?>
					<form method="post" action="<?php echo admin_url('admin-post.php'); ?>" style="display:inline;">
						<input type="hidden" name="action" value="install_single_plugin">
						<input type="hidden" name="slug" value="<?php echo esc_attr($slug); ?>">
						<?php wp_nonce_field('install_single_plugin'); ?>
						<button type="submit" class="button button-small button-primary">Установить</button>
					</form>
					<?php
					$button = ob_get_clean();
				}
				?>
				<li style="margin-bottom:5px;">
					<strong><?php echo esc_html($plugin['name']); ?></strong> — <?php echo $status; ?> 		<?php echo $button; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
}
add_action('admin_post_install_single_plugin', function () {
	if (!current_user_can('install_plugins'))
		wp_die('Недостаточно прав');
	check_admin_referer('install_single_plugin');

	if (!isset($_POST['slug']))
		wp_die('Нет плагина');
	$slug = sanitize_text_field($_POST['slug']);

	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	$installed = get_plugins("/{$slug}");
	if (!$installed) {
		$api = plugins_api('plugin_information', ['slug' => $slug, 'fields' => ['sections' => false]]);
		if (!is_wp_error($api)) {
			$upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
			$upgrader->install($api->download_link);

			$plugin_files = get_plugins("/{$slug}");
			if ($plugin_files) {
				$plugin_file = $slug . '/' . array_key_first($plugin_files);
				activate_plugin($plugin_file);
			}
		}
	}

	wp_safe_redirect(admin_url('admin.php?page=custom-site-settings'));
	exit;
});

add_action('admin_post_install_all_plugins', function () {
	if (!current_user_can('install_plugins'))
		wp_die('Недостаточно прав');
	check_admin_referer('install_all_plugins');

	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	foreach (my_required_plugins() as $plugin) {
		$slug = $plugin['slug'];
		$installed = get_plugins("/{$slug}");
		if (!$installed) {
			$api = plugins_api('plugin_information', ['slug' => $slug, 'fields' => ['sections' => false]]);
			if (!is_wp_error($api)) {
				$upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());
				$upgrader->install($api->download_link);

				$plugin_files = get_plugins("/{$slug}");
				if ($plugin_files) {
					$plugin_file = $slug . '/' . array_key_first($plugin_files);
					activate_plugin($plugin_file);
				}
			}
		}
	}

	wp_safe_redirect(admin_url('admin.php?page=custom-site-settings'));
	exit;
});

