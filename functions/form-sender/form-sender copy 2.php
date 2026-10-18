<?php
/**
 * WebCraft Forms v3.6 — AJAX + индикатор + сообщения под формой
 * Изменения относительно v3.5:
 *   • AJAX-обработчик (wcf_ajax_submit) — без перезагрузки страницы
 *   • Старый admin_post_ оставлен для совместимости
 *   • Универсальный JS следит за ВСЕМИ .wcf-form на странице
 *   • Индикатор на кнопке + блокировка формы во время отправки
 *   • Сообщение об успехе / ошибке вставляется под формой
 *   • Редирект — через JS (window.location) по данным из JSON-ответа
 *   • wcf_form_fields() — хелпер для произвольных форм без шорткода
 *   • Скрипт и стили подключаются через wp_enqueue
 */

// ============================================================================
// ⚙️ КОНСТАНТЫ
// ============================================================================
define('WCF_UPLOAD_DIR', 'webcraft-forms');
define('WCF_DEFAULT_MAX_SIZE', 5 * 1024 * 1024);
define('WCF_DEFAULT_EXTENSIONS', 'jpg,jpeg,png,pdf,doc,docx');

// ============================================================================
// 🗄️ 1. CPT ДЛЯ ХРАНЕНИЯ ЗАЯВОК
// ============================================================================
add_action('init', 'wcf_init_cpt');
function wcf_init_cpt()
{
	register_post_type('wcf_submission', array(
		'labels' => array(
			'name' => 'Заявки форм',
			'singular_name' => 'Заявка',
			'menu_name' => 'Заявки',
			'search_items' => 'Поиск заявок',
			'not_found' => 'Заявок нет',
		),
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => 'wcf-forms',
		'supports' => array('title', 'custom-fields'),
		'capability_type' => 'post',
		'rewrite' => false,
		'query_var' => false,
		'can_export' => true,
	));
}

// Метабокс для просмотра данных заявки
add_action('add_meta_boxes', 'wcf_add_submission_metabox');
function wcf_add_submission_metabox()
{
	add_meta_box('wcf_submission_data', '📋 Данные заявки', 'wcf_render_submission_metabox', 'wcf_submission', 'normal', 'high');
}
function wcf_render_submission_metabox($post)
{
	$form_id = get_post_meta($post->ID, '_wcf_form_id', true);
	$form_name = get_post_meta($post->ID, '_wcf_form_name', true);
	$ip = get_post_meta($post->ID, '_wcf_ip', true);
	$time = get_post_meta($post->ID, '_wcf_time', true);
	$files = maybe_unserialize(get_post_meta($post->ID, '_wcf_files', true));

	echo '<div style="background:#fff; padding:15px; border:1px solid #e2e4e7; border-radius:4px;">';
	echo '<p><strong>Форма:</strong> ' . esc_html($form_name ?: $form_id) . ' <small style="color:#666">(' . esc_html($form_id) . ')</small> | <strong>IP:</strong> ' . esc_html($ip) . ' | <strong>Время:</strong> ' . esc_html(date('d.m.Y H:i', $time)) . '</p><hr style="margin:10px 0;">';
	echo '<table style="width:100%; border-collapse:collapse;">';
	foreach (get_post_custom($post->ID) as $key => $val) {
		if (strpos($key, '_wcf_') === 0 && !in_array($key, ['_wcf_form_id', '_wcf_form_name', '_wcf_ip', '_wcf_time', '_wcf_files'])) {
			$field = str_replace('_wcf_', '', $key);
			$val = maybe_unserialize($val);
			$forms = get_option('wcf_forms', []);
			$labels = !empty($forms[$form_id]['field_labels']) ? wcf_parse_field_labels($forms[$form_id]['field_labels']) : [];
			$label = isset($labels[$field]) ? $labels[$field] : ucfirst(str_replace(['_', '-'], ' ', $field));
			echo '<tr><td style="padding:8px; width:30%; font-weight:bold; background:#f9f9f9; border:1px solid #eee;">' . esc_html($label) . '</td>';
			echo '<td style="padding:8px; border:1px solid #eee; white-space:pre-wrap;">' . nl2br(esc_html(is_array($val) ? implode(', ', $val) : $val)) . '</td></tr>';
		}
	}
	if (!empty($files) && is_array($files)) {
		echo '<tr><td style="padding:8px; font-weight:bold; background:#f9f9f9; border:1px solid #eee;">📎 Файлы</td><td style="padding:8px; border:1px solid #eee;">' . implode('<br>', array_map('esc_html', $files)) . '</td></tr>';
	}
	echo '</table></div>';
}

// ============================================================================
// ⚙️ 2. АДМИН-ПАНЕЛЬ
// ============================================================================
add_action('admin_menu', 'wcf_admin_menu');
function wcf_admin_menu()
{
	add_menu_page('WebCraft Forms', 'Формы WebCraft', 'manage_options', 'wcf-forms', 'wcf_page_forms_list', 'dashicons-feedback', 25);
	add_submenu_page('wcf-forms', 'Все формы', 'Все формы', 'manage_options', 'wcf-forms', 'wcf_page_forms_list');
	add_submenu_page('wcf-forms', 'Добавить форму', '+ Добавить', 'manage_options', 'wcf-form-edit', 'wcf_page_form_edit');
}

function wcf_page_forms_list()
{
	$forms = get_option('wcf_forms', array());
	?>
	<div class="wrap">
		<h1>📋 Формы WebCraft <a href="<?php echo admin_url('admin.php?page=wcf-form-edit'); ?>" class="page-title-action">+
				Добавить форму</a></h1>
		<?php if (empty($forms)): ?>
			<div class="card" style="max-width:600px; margin-top:20px; padding:20px;">
				<p>🎯 Форм пока нет. <a href="<?php echo admin_url('admin.php?page=wcf-form-edit'); ?>">Создайте первую форму</a>
				</p>
			</div>
		<?php else: ?>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th>Название / ID</th>
						<th>Куда отправлять</th>
						<th>Редирект</th>
						<th>Действия</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($forms as $id => $form): ?>
						<tr>
							<td><strong><?php echo esc_html($form['form_name'] ?? $id); ?></strong><br><small style="color:#666;">ID:
									<?php echo esc_html($id); ?></small></td>
							<td>
								<?php echo esc_html($form['emails'] ?? '—'); ?>
								<?php if (!empty($form['telegram_enabled'])): ?><br><small>📬 Telegram</small><?php endif; ?>
								<?php if (!empty($form['crm_enabled'])): ?><br><small>🏢 CRM</small><?php endif; ?>
							</td>
							<td>
								<?php echo !empty($form['redirect_url']) ? '<small>' . esc_url($form['redirect_url']) . '</small>' : '—'; ?>
							</td>
							<td>
								<a href="<?php echo admin_url('admin.php?page=wcf-form-edit&form_id=' . urlencode($id)); ?>"
									class="button button-small">✏️</a>
								<button class="button button-small button-link-delete wcf-delete-form"
									data-form="<?php echo esc_attr($id); ?>">🗑️</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
	<script>
		document.querySelectorAll('.wcf-delete-form').forEach(btn => {
			btn.addEventListener('click', function () {
				if (!confirm('Удалить настройки формы? Заявки в БД сохранятся.')) return;
				const data = new FormData();
				data.append('action', 'wcf_delete_form');
				data.append('form_id', this.dataset.form);
				data.append('_wpnonce', '<?php echo wp_create_nonce("wcf_delete_form"); ?>');
				fetch(ajaxurl, { method: 'POST', body: data }).then(r => r.json()).then(res => {
					if (res.success) location.reload(); else alert(res.data);
				});
			});
		});
	</script>
	<?php
}

function wcf_page_form_edit()
{
	$form_id = isset($_GET['form_id']) ? sanitize_key($_GET['form_id']) : '';
	$forms = get_option('wcf_forms', array());
	$form = $form_id && isset($forms[$form_id]) ? $forms[$form_id] : wcf_default_form_config();
	$is_new = empty($form_id);
	$redirect_display = $form['redirect_url'] ?? '';
	if (strpos($redirect_display, home_url()) === 0)
		$redirect_display = str_replace(home_url(), '', $redirect_display);
	?>
	<div class="wrap">
		<h1><?php echo $is_new ? '➕ Новая форма' : '✏️ Редактировать: ' . esc_html($form['form_name'] ?? $form_id); ?></h1>
		<form method="post" id="wcf-form-settings">
			<input type="hidden" name="wcf_action" value="save_form">
			<input type="hidden" name="form_id_old" value="<?php echo esc_attr($form_id); ?>">
			<input type="hidden" name="redirect_url" id="wcf-redirect-hidden"
				value="<?php echo esc_attr($form['redirect_url'] ?? ''); ?>">
			<?php wp_nonce_field('wcf_save_form', 'wcf_nonce'); ?>

			<div class="wcf-tabs">
				<div class="wcf-tab-nav">
					<button type="button" class="active" data-tab="main">🔹 Основные</button>
					<button type="button" data-tab="redirect">🔁 Редирект</button>
					<button type="button" data-tab="telegram">📬 Telegram</button>
					<button type="button" data-tab="crm">🏢 CRM</button>
					<button type="button" data-tab="messages">💬 Сообщения</button>
				</div>

				<div class="wcf-tab-content active" id="tab-main">
					<table class="form-table">
						<tr>
							<th><label>ID формы *</label></th>
							<td>
								<input type="text" name="form_id" value="<?php echo esc_attr($form_id); ?>" class="regular-text"
									pattern="[a-z0-9_]+" required <?php echo !$is_new ? 'readonly style="background:#f9f9f9"' : ''; ?>>
								<p class="description">Латиница, цифры, подчёркивание. Не меняется!</p>
							</td>
						</tr>
						<tr>
							<th><label>🏷️ Название формы</label></th>
							<td>
								<input type="text" name="form_name" value="<?php echo esc_attr($form['form_name'] ?? ''); ?>"
									class="regular-text" placeholder="Заказ звонка, Заявка на мебель...">
								<p class="description">Отображается в письмах, Телеграме, админке.</p>
							</td>
						</tr>
						<tr>
							<th><label>📧 Email получатели</label></th>
							<td><input type="text" name="emails"
									value="<?php echo esc_attr($form['emails'] ?? get_option('admin_email')); ?>"
									class="regular-text" placeholder="admin@site.by, manager@site.by"></td>
						</tr>
						<tr>
							<th><label>📎 Файлы (расширения / макс. МБ)</label></th>
							<td>
								<input type="text" name="allowed_files"
									value="<?php echo esc_attr($form['allowed_files'] ?? WCF_DEFAULT_EXTENSIONS); ?>"
									class="regular-text" style="width:60%">
								<input type="number" name="max_file_size"
									value="<?php echo esc_attr($form['max_file_size'] ?? 5); ?>" min="1" max="50"
									style="width:70px;">
							</td>
						</tr>
						<tr>
							<th><label>🏷️ Названия полей (русские)</label></th>
							<td>
								<textarea name="field_labels" rows="4" class="large-text" style="font-family:monospace;"
									placeholder="name=Имя&#10;phone=Телефон&#10;email=Email"><?php echo esc_textarea($form['field_labels'] ?? ''); ?></textarea>
								<p class="description">Формат: <code>field_name=Название</code>, каждое с новой строки.</p>
							</td>
						</tr>
					</table>
					<h2 style="margin-top:25px;">✉️ Шаблон письма</h2>
					<p class="description">Переменные: <code>{form_name}</code>, <code>{name}</code>, <code>{phone}</code>,
						<code>{field:custom}</code>, <code>{date}</code>, <code>{ip}</code>, <code>{site_name}</code>,
						<code>{fields_table}</code>, <code>{if_files}...{/if_files}</code></p>
					<textarea name="email_template" rows="15" class="large-text code"
						style="font-family:monospace; width:100%;"><?php echo esc_textarea($form['email_template'] ?? wcf_default_email_template()); ?></textarea>
				</div>

				<div class="wcf-tab-content" id="tab-redirect">
					<table class="form-table">
						<tr>
							<th><label>URL страницы "Спасибо"</label></th>
							<td>
								<input type="text" name="redirect_url_input" id="wcf-redirect-input"
									value="<?php echo esc_attr($redirect_display); ?>" class="regular-text"
									placeholder="/thank-you/">
								<div id="wcf-redirect-preview"
									style="margin-top:8px; padding:8px; background:#f0f6fc; border-left:3px solid #0073aa; border-radius:4px; font-size:13px; display:none;">
									<strong>Будет:</strong> <span id="wcf-redirect-result"></span>
								</div>
								<p class="description">Введите <code>/slug/</code> или полный URL. Если пусто — сообщение выведется
									под формой.</p>
								<?php $pages = get_pages(['sort_column' => 'post_title', 'post_status' => 'publish']);
								if ($pages): ?>
									<select id="wcf-page-select" style="max-width:300px; margin-top:5px;">
										<option value="">— Выберите страницу —</option>
										<?php foreach ($pages as $p): ?>
											<option value="/<?php echo esc_attr(get_page_uri($p->ID)); ?>/">
												<?php echo esc_html($p->post_title); ?></option>
										<?php endforeach; ?>
									</select>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<th><label>✅ Передавать данные в GET</label></th>
							<td><label><input type="checkbox" name="redirect_with_data" value="1" <?php checked(!empty($form['redirect_with_data'])); ?>> Добавить поля формы в адрес</label></td>
						</tr>
						<tr>
							<th><label>📤 Поля для передачи</label></th>
							<td>
								<input type="text" name="redirect_fields"
									value="<?php echo esc_attr($form['redirect_fields'] ?? 'name,phone,email'); ?>"
									class="regular-text" placeholder="name,phone,email">
								<p class="description">Через запятую</p>
							</td>
						</tr>
					</table>
				</div>

				<div class="wcf-tab-content" id="tab-telegram">
					<table class="form-table">
						<tr>
							<th><label>Включить уведомления</label></th>
							<td><label><input type="checkbox" name="telegram_enabled" value="1" <?php checked(!empty($form['telegram_enabled'])); ?>> Отправлять в Telegram</label></td>
						</tr>
						<tr>
							<th><label>Bot Token</label></th>
							<td><input type="text" name="telegram_token"
									value="<?php echo esc_attr($form['telegram_token'] ?? ''); ?>" class="regular-text"
									style="width:100%; box-sizing:border-box;" placeholder="123456:ABC-DEF..."></td>
						</tr>
						<tr>
							<th><label>Chat ID(s)</label></th>
							<td>
								<textarea name="telegram_chat_id" id="tg-chat-id" rows="4" class="large-text"
									style="font-family:monospace; width:100%;"><?php echo esc_textarea($form['telegram_chat_id'] ?? ''); ?></textarea>
								<p class="description">Каждый ID с новой строки или через запятую.</p>
								<div style="margin-top:8px; display:flex; gap:8px; align-items:center;">
									<select id="tg-chat-select" style="flex:1; display:none;">
										<option value="">⬇️ Выберите чат для добавления...</option>
									</select>
									<button type="button" id="tg-find-btn" class="button">🔍 Найти чаты</button>
								</div>
							</td>
						</tr>
					</table>
				</div>

				<div class="wcf-tab-content" id="tab-crm">
					<table class="form-table">
						<tr>
							<th><label>Включить CRM</label></th>
							<td><label><input type="checkbox" name="crm_enabled" value="1" <?php checked(!empty($form['crm_enabled'])); ?>> Отправлять лид</label></td>
						</tr>
						<tr>
							<th><label>Webhook URL</label></th>
							<td><input type="url" name="crm_webhook" value="<?php echo esc_attr($form['crm_webhook'] ?? ''); ?>"
									class="regular-text" placeholder="https://portal.bitrix24.ru/rest/1/xxx/"></td>
						</tr>
						<tr>
							<th><label>Шаблон названия лида</label></th>
							<td><input type="text" name="crm_title_template"
									value="<?php echo esc_attr($form['crm_title_template'] ?? '$ - {name} ({form_name})'); ?>"
									class="regular-text"></td>
						</tr>
					</table>
				</div>

				<!-- Новая вкладка: тексты сообщений -->
				<div class="wcf-tab-content" id="tab-messages">
					<table class="form-table">
						<tr>
							<th><label>✅ Текст успеха</label></th>
							<td>
								<input type="text" name="success_message"
									value="<?php echo esc_attr($form['success_message'] ?? 'Спасибо! Ваша заявка принята. Мы свяжемся с вами в ближайшее время.'); ?>"
									class="large-text">
								<p class="description">Выводится под формой после успешной отправки (если нет редиректа).</p>
							</td>
						</tr>
						<tr>
							<th><label>⚠️ Текст ошибки (общий)</label></th>
							<td>
								<input type="text" name="error_message"
									value="<?php echo esc_attr($form['error_message'] ?? 'Произошла ошибка при отправке. Попробуйте ещё раз или свяжитесь с нами напрямую.'); ?>"
									class="large-text">
								<p class="description">Выводится под формой при ошибке сервера. Конкретные ошибки (файл, спам)
									показываются автоматически.</p>
							</td>
						</tr>
						<tr>
							<th><label>⏳ Текст на кнопке во время отправки</label></th>
							<td>
								<input type="text" name="sending_text"
									value="<?php echo esc_attr($form['sending_text'] ?? 'Отправка...'); ?>" class="regular-text">
							</td>
						</tr>
					</table>
				</div>
			</div>

			<p style="margin:20px 0;">
				<button type="submit" class="button button-primary button-hero">💾 Сохранить форму</button>
				<?php if (!$is_new): ?><a href="<?php echo admin_url('admin.php?page=wcf-forms'); ?>" class="button">←
						Назад</a><?php endif; ?>
			</p>
		</form>
	</div>

	<style>
		.wcf-tabs {
			margin-top: 20px;
			background: #fff;
			border: 1px solid #c3c4c7;
			border-radius: 4px;
		}

		.wcf-tab-nav {
			display: flex;
			border-bottom: 1px solid #c3c4c7;
			background: #f6f7f7;
			flex-wrap: wrap;
		}

		.wcf-tab-nav button {
			background: none;
			border: none;
			padding: 10px 15px;
			cursor: pointer;
			font-size: 14px;
			border-right: 1px solid #c3c4c7;
		}

		.wcf-tab-nav button.active {
			background: #fff;
			border-bottom: 1px solid #fff;
			margin-bottom: -1px;
			font-weight: bold;
			color: #0073aa;
		}

		.wcf-tab-content {
			padding: 20px;
			display: none;
		}

		.wcf-tab-content.active {
			display: block;
		}
	</style>
	<script>
		document.querySelectorAll('.wcf-tab-nav button').forEach(btn => {
			btn.addEventListener('click', function () {
				document.querySelectorAll('.wcf-tab-content').forEach(c => c.classList.remove('active'));
				document.querySelectorAll('.wcf-tab-nav button').forEach(b => b.classList.remove('active'));
				document.getElementById('tab-' + this.dataset.tab).classList.add('active');
				this.classList.add('active');
			});
		});
		const inp = document.getElementById('wcf-redirect-input');
		const hid = document.getElementById('wcf-redirect-hidden');
		const prev = document.getElementById('wcf-redirect-preview');
		const res = document.getElementById('wcf-redirect-result');
		const home = '<?php echo home_url(); ?>';
		const upd = () => {
			if (!inp) return; let v = inp.value.trim(), full = v;
			if (!v) { prev.style.display = 'none'; hid.value = ''; return; }
			if (v.startsWith('/') && !v.startsWith('//')) full = home + v.replace(/\/+/g, '/');
			else if (!v.startsWith('http')) full = home + '/' + v;
			res.textContent = full; prev.style.display = 'block'; hid.value = full;
		};
		if (inp) { inp.addEventListener('input', upd); if (inp.value) upd(); }
		document.getElementById('wcf-page-select')?.addEventListener('change', function () { if (this.value) { inp.value = this.value; upd(); } });
		const tgBtn = document.getElementById('tg-find-btn');
		const tgSelect = document.getElementById('tg-chat-select');
		const tgInput = document.getElementById('tg-chat-id');
		const tgToken = document.querySelector('[name="telegram_token"]');
		if (tgBtn) {
			tgBtn.addEventListener('click', function () {
				const token = tgToken ? tgToken.value.trim() : '';
				if (!token) { alert('Сначала введите Token бота!'); return; }
				this.textContent = '⏳ Ищем...'; this.disabled = true;
				const data = new FormData();
				data.append('action', 'wcf_get_telegram_chats'); data.append('token', token);
				data.append('nonce', '<?php echo wp_create_nonce("wcf_tg_chats"); ?>');
				fetch(ajaxurl, { method: 'POST', body: data }).then(r => r.json()).then(res => {
					tgBtn.textContent = '🔍 Найти чаты'; tgBtn.disabled = false;
					if (res.success) {
						tgSelect.style.display = 'block';
						tgSelect.innerHTML = '<option value="">⬇️ Выберите чат для добавления...</option>';
						res.data.forEach(chat => { const o = document.createElement('option'); o.value = chat.id; o.textContent = `${chat.type}: ${chat.name} (${chat.id})`; tgSelect.appendChild(o); });
					} else alert('❌ ' + (res.data || 'Не удалось получить чаты'));
				}).catch(() => { tgBtn.textContent = '🔍 Найти чаты'; tgBtn.disabled = false; alert('Ошибка запроса'); });
			});
			tgSelect.addEventListener('change', function () {
				if (this.value && tgInput) {
					let ids = tgInput.value.trim() ? tgInput.value.trim().split(/[\n,]+/).map(s => s.trim()).filter(Boolean) : [];
					if (!ids.includes(this.value)) { ids.push(this.value); tgInput.value = ids.join(', '); }
					this.value = '';
				}
			});
		}
	</script>
	<?php
}

add_action('admin_init', 'wcf_save_form_settings');
function wcf_save_form_settings()
{
	if (!isset($_POST['wcf_action'], $_POST['wcf_nonce']) || $_POST['wcf_action'] !== 'save_form')
		return;
	if (!wp_verify_nonce($_POST['wcf_nonce'], 'wcf_save_form'))
		return;
	if (!current_user_can('manage_options'))
		return;

	$form_id = sanitize_key($_POST['form_id']);
	$form_id_old = sanitize_key($_POST['form_id_old'] ?? '');
	$forms = get_option('wcf_forms', array());
	if ($form_id_old && $form_id_old !== $form_id && isset($forms[$form_id_old]))
		unset($forms[$form_id_old]);

	$redirect_raw = $_POST['redirect_url'] ?? '';
	if (!empty($redirect_raw)) {
		if (strpos($redirect_raw, '/') === 0 && strpos($redirect_raw, '//') !== 0)
			$redirect_raw = home_url(rtrim($redirect_raw, '/') . '/');
		elseif (strpos($redirect_raw, 'http') !== 0)
			$redirect_raw = home_url($redirect_raw);
	}

	$forms[$form_id] = array(
		'form_name' => sanitize_text_field($_POST['form_name'] ?? ''),
		'emails' => sanitize_text_field($_POST['emails'] ?? get_option('admin_email')),
		'email_template' => wp_kses_post($_POST['email_template'] ?? wcf_default_email_template()),
		'field_labels' => sanitize_textarea_field($_POST['field_labels'] ?? ''),
		'redirect_url' => esc_url_raw($redirect_raw),
		'redirect_with_data' => !empty($_POST['redirect_with_data']),
		'redirect_fields' => sanitize_text_field($_POST['redirect_fields'] ?? 'name,phone,email'),
		'allowed_files' => sanitize_text_field($_POST['allowed_files'] ?? WCF_DEFAULT_EXTENSIONS),
		'max_file_size' => absint($_POST['max_file_size'] ?? 5),
		'telegram_enabled' => !empty($_POST['telegram_enabled']),
		'telegram_token' => sanitize_text_field($_POST['telegram_token'] ?? ''),
		'telegram_chat_id' => wcf_sanitize_chat_ids($_POST['telegram_chat_id'] ?? ''),
		'crm_enabled' => !empty($_POST['crm_enabled']),
		'crm_webhook' => esc_url_raw($_POST['crm_webhook'] ?? ''),
		'crm_title_template' => sanitize_text_field($_POST['crm_title_template'] ?? '$ - {name} ({form_name})'),
		// Новые поля для сообщений
		'success_message' => sanitize_text_field($_POST['success_message'] ?? 'Спасибо! Ваша заявка принята. Мы свяжемся с вами в ближайшее время.'),
		'error_message' => sanitize_text_field($_POST['error_message'] ?? 'Произошла ошибка при отправке. Попробуйте ещё раз или свяжитесь с нами напрямую.'),
		'sending_text' => sanitize_text_field($_POST['sending_text'] ?? 'Отправка...'),
		'save_to_db' => true,
		'created' => isset($forms[$form_id]) ? $forms[$form_id]['created'] : current_time('mysql'),
		'modified' => current_time('mysql'),
	);

	update_option('wcf_forms', $forms);
	wp_safe_redirect(admin_url('admin.php?page=wcf-form-edit&form_id=' . urlencode($form_id) . '&updated=1'));
	exit;
}

function wcf_sanitize_chat_ids($input)
{
	$ids = preg_split('/[\n,]+/', $input);
	$clean = [];
	foreach ($ids as $id) {
		$id = trim($id);
		if (preg_match('/^-?\d+$/', $id))
			$clean[] = $id;
	}
	return implode(', ', array_unique($clean));
}
function wcf_parse_field_labels($input)
{
	$labels = [];
	foreach (explode("\n", $input) as $line) {
		$line = trim($line);
		if (empty($line) || strpos($line, '=') === false)
			continue;
		[$key, $val] = array_map('trim', explode('=', $line, 2));
		if (!empty($key) && !empty($val))
			$labels[sanitize_key($key)] = sanitize_text_field($val);
	}
	return $labels;
}

add_action('wp_ajax_wcf_delete_form', function () {
	check_ajax_referer('wcf_delete_form');
	if (!current_user_can('manage_options'))
		wp_send_json_error('Нет прав');
	$forms = get_option('wcf_forms', []);
	$id = sanitize_key($_POST['form_id'] ?? '');
	if (isset($forms[$id])) {
		unset($forms[$id]);
		update_option('wcf_forms', $forms);
		wp_send_json_success();
	}
	wp_send_json_error('Форма не найдена');
});

add_action('wp_ajax_wcf_get_telegram_chats', function () {
	check_ajax_referer('wcf_tg_chats', 'nonce');
	if (!current_user_can('manage_options'))
		wp_send_json_error('Нет прав');
	$token = sanitize_text_field($_POST['token'] ?? '');
	if (empty($token))
		wp_send_json_error('Введите Token');
	$response = wp_remote_get("https://api.telegram.org/bot{$token}/getUpdates?limit=50");
	if (is_wp_error($response))
		wp_send_json_error('Ошибка соединения');
	$body = json_decode(wp_remote_retrieve_body($response), true);
	if (empty($body['ok']))
		wp_send_json_error('Токен неверный или бот заблокирован');
	$chats = [];
	$seen = [];
	foreach ($body['result'] as $up) {
		$chat = $up['message']['chat'] ?? $up['edited_message']['chat'] ?? $up['channel_post']['chat'] ?? $up['my_chat_member']['chat'] ?? null;
		if (!$chat || in_array($chat['id'], $seen))
			continue;
		$seen[] = $chat['id'];
		$full_name = trim($chat['first_name'] . ' ' . ($chat['last_name'] ?? ''));
		$name = $chat['title'] ?? ($chat['username'] ? "@{$chat['username']}" : ($full_name ?: 'Личный'));
		$chats[] = ['id' => (string) $chat['id'], 'name' => trim($name), 'type' => ucfirst($chat['type'] ?? 'private')];
	}
	if (empty($chats))
		wp_send_json_error('Чаты не найдены. Напишите боту /start в нужном месте.');
	wp_send_json_success($chats);
});

function wcf_default_form_config()
{
	return [
		'form_name' => '',
		'emails' => get_option('admin_email'),
		'email_template' => wcf_default_email_template(),
		'field_labels' => '',
		'redirect_url' => '',
		'redirect_with_data' => false,
		'redirect_fields' => 'name,phone,email',
		'allowed_files' => WCF_DEFAULT_EXTENSIONS,
		'max_file_size' => 5,
		'telegram_enabled' => false,
		'crm_enabled' => false,
		'save_to_db' => true,
		'success_message' => 'Спасибо! Ваша заявка принята. Мы свяжемся с вами в ближайшее время.',
		'error_message' => 'Произошла ошибка при отправке. Попробуйте ещё раз или свяжитесь с нами напрямую.',
		'sending_text' => 'Отправка...',
	];
}
function wcf_default_email_template()
{
	return '<h3>📩 Заявка: {form_name}</h3><p><strong>Дата:</strong> {date}<br><strong>IP:</strong> {ip}<br><strong>Сайт:</strong> <a href="{site_url}">{site_name}</a></p><hr>{fields_table}{if_files}<p><strong>📎 Файлы:</strong><br>{files_list}</p>{/if_files}<p style="margin-top:30px;font-size:12px;color:#666;">Авто-письмо.</p>';
}

// ============================================================================
// 🔐 3. ЗАЩИТА
// ============================================================================
function wcf_form_nonce_field($form_id)
{
	wp_nonce_field('wcf_form_' . $form_id, '_wcf_nonce');
	echo '<input type="text" name="_wcf_hp" class="wcf-hp" autocomplete="off" tabindex="-1" aria-hidden="true" style="position:absolute; left:-9999px; opacity:0;">';
}
function wcf_verify_submission($form_id)
{
	if (!isset($_POST['_wcf_nonce']) || !wp_verify_nonce($_POST['_wcf_nonce'], 'wcf_form_' . $form_id))
		return new WP_Error('nonce', 'Ошибка безопасности. Обновите страницу и попробуйте снова.');
	if (!empty($_POST['_wcf_hp'])) {
		wcf_log("Spam honeypot: {$_SERVER['REMOTE_ADDR']}", 'warn');
		return new WP_Error('spam', 'Ошибка');
	}
	$key = 'wcf_rl_' . md5($_SERVER['REMOTE_ADDR'] . '_' . $form_id);
	if (get_transient($key))
		return new WP_Error('rate', 'Подождите 15 секунд перед повторной отправкой.');
	set_transient($key, '1', 15);
	return true;
}

// ============================================================================
// ✉️ 4. ПИСЬМА
// ============================================================================
function wcf_parse_template($tpl, $data, $form_id, $form_name, $files = [], $labels = [])
{
	$vars = [
		'{date}' => current_time('d.m.Y H:i'),
		'{ip}' => $_SERVER['REMOTE_ADDR'] ?? 'N/A',
		'{site_name}' => get_bloginfo('name'),
		'{site_url}' => home_url(),
		'{form_id}' => $form_id,
		'{form_name}' => $form_name ?: $form_id,
		'{fields_table}' => wcf_format_fields_table($data, $labels),
	];
	foreach ($data as $k => $v) {
		$vars['{' . $k . '}'] = nl2br(esc_html($v));
		$vars['{field:' . $k . '}'] = nl2br(esc_html($v));
	}
	if (!empty($files)) {
		$fl = '';
		foreach ($files as $f)
			$fl .= '• ' . esc_html(basename($f)) . '<br>';
		$vars['{files_list}'] = $fl;
		$vars['{if_files}'] = '';
		$vars['{/if_files}'] = '';
	} else {
		$tpl = preg_replace('#\{if_files\}.*?\{/if_files\}#s', '', $tpl);
	}
	return str_replace(array_keys($vars), array_values($vars), $tpl);
}
function wcf_format_fields_table($data, $labels = [])
{
	$h = '<table style="width:100%; border-collapse:collapse; font-family:Arial, sans-serif;">';
	foreach ($data as $k => $v) {
		$label = isset($labels[$k]) ? $labels[$k] : ucfirst(str_replace(['_', '-'], ' ', $k));
		$h .= '<tr><td style="padding:10px; border:1px solid #eee; width:30%; background:#f9f9f9; font-weight:bold;">' . esc_html($label) . '</td><td style="padding:10px; border:1px solid #eee;">' . nl2br(esc_html($v)) . '</td></tr>';
	}
	return $h . '</table>';
}
function wcf_send_email($to, $subject, $body, $attachments = [])
{
	$headers = "From: " . get_bloginfo('name') . " <" . get_option('admin_email') . ">\r\n";
	$headers .= "Reply-To: " . get_option('admin_email') . "\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
	return wp_mail($to, $subject, $body, $headers, $attachments);
}

// ============================================================================
// 📬 5. TELEGRAM & 🏢 CRM
// ============================================================================
function wcf_send_telegram($token, $chat_ids_str, $data, $form_id, $form_name, $files = [], $labels = [])
{
	if (empty($token) || empty($chat_ids_str))
		return false;
	$ids = array_unique(array_filter(array_map('trim', explode(',', $chat_ids_str))));
	$ids = array_filter($ids, fn($id) => preg_match('/^-?\d+$/', $id));
	if (empty($ids))
		return false;

	$display_name = $form_name ?: $form_id;
	$txt = "📩 *Заявка: {$display_name}*\n\n";
	foreach ($data as $k => $v) {
		$label = isset($labels[$k]) ? $labels[$k] : ucfirst(str_replace('_', ' ', $k));
		$txt .= "*{$label}*: " . wp_strip_all_tags($v) . "\n";
	}
	$txt .= "\n🌐 " . home_url();

	$sent_chats = [];
	foreach ($ids as $chat_id) {
		if (in_array($chat_id, $sent_chats))
			continue;
		$r = wp_remote_post("https://api.telegram.org/bot{$token}/sendMessage", [
			'body' => json_encode(['chat_id' => $chat_id, 'text' => $txt, 'parse_mode' => 'Markdown']),
			'headers' => ['Content-Type' => 'application/json'],
			'timeout' => 15,
		]);
		if (!is_wp_error($r) && wp_remote_retrieve_response_code($r) === 200) {
			$sent_chats[] = $chat_id;
			foreach ($files as $file_path) {
				if (!file_exists($file_path))
					continue;
				$boundary = wp_generate_password(24, false);
				$body = "--{$boundary}\r\nContent-Disposition: form-data; name=\"chat_id\"\r\n\r\n{$chat_id}\r\n";
				$body .= "--{$boundary}\r\nContent-Disposition: form-data; name=\"document\"; filename=\"" . basename($file_path) . "\"\r\nContent-Type: " . mime_content_type($file_path) . "\r\n\r\n" . file_get_contents($file_path) . "\r\n";
				$body .= "--{$boundary}\r\nContent-Disposition: form-data; name=\"caption\"\r\n\r\n{$txt}\r\n";
				$body .= "--{$boundary}\r\nContent-Disposition: form-data; name=\"parse_mode\"\r\n\r\nMarkdown\r\n--{$boundary}--";
				wp_remote_post("https://api.telegram.org/bot{$token}/sendDocument", [
					'body' => $body,
					'headers' => ['Content-Type' => 'multipart/form-data; boundary=' . $boundary, 'Content-Length' => strlen($body)],
					'timeout' => 45,
				]);
			}
		}
	}
	return count($sent_chats) > 0;
}
function wcf_send_crm($data, $config, $form_id, $form_name)
{
	if (empty($config['crm_enabled']) || empty($config['crm_webhook']))
		return false;
	$display_name = $form_name ?: $form_id;
	$title = $config['crm_title_template'] ?? '$ - {name}';
	foreach ($data as $k => $v)
		$title = str_replace('{' . $k . '}', $v, $title);
	$title = str_replace(['{form_id}', '{form_name}'], [$form_id, $display_name], $title);
	$lead = [
		'TITLE' => $title,
		'NAME' => $data['name'] ?? '',
		'PHONE' => $data['phone'] ?? $data['tel'] ?? '',
		'EMAIL' => $data['email'] ?? '',
		'COMMENTS' => implode("\n", array_map(fn($k, $v) => ucfirst($k) . ': ' . wp_strip_all_tags($v), array_keys($data), $data)),
		'SOURCE_ID' => 'FORM',
		'SOURCE_DESCRIPTION' => home_url(),
	];
	$webhook = rtrim($config['crm_webhook'], '/') . '/crm.lead.add.json';
	$r = wp_remote_post($webhook, ['body' => json_encode(['fields' => $lead]), 'headers' => ['Content-Type' => 'application/json'], 'timeout' => 20]);
	return !is_wp_error($r) && wp_remote_retrieve_response_code($r) === 200;
}

// ============================================================================
// 📎 6. ФАЙЛЫ
// ============================================================================
function wcf_handle_files($files, $form_id, $config)
{
	if (empty($files))
		return [];
	$upload_dir = wp_upload_dir();
	$dir = $upload_dir['basedir'] . '/' . WCF_UPLOAD_DIR . '/' . $form_id . '/' . date('Y-m');
	if (!file_exists($dir)) {
		wp_mkdir_p($dir);
		file_put_contents($dir . '/index.php', '<?php // Silence');
		$exts = str_replace(',', '|', $config['allowed_files'] ?? WCF_DEFAULT_EXTENSIONS);
		file_put_contents($dir . '/.htaccess', "Deny from all\n<Files ~ \"\.({$exts})$\">\nAllow from all\n</Files>");
	}
	$allowed = array_map('trim', explode(',', $config['allowed_files'] ?? WCF_DEFAULT_EXTENSIONS));
	$max_size = ($config['max_file_size'] ?? 5) * 1024 * 1024;
	$uploaded = [];
	foreach ($files as $field => $file) {
		if (!is_array($file) || empty($file['name']))
			continue;
		$is_multi = is_array($file['name']);
		$names = $is_multi ? $file['name'] : [$file['name']];
		foreach ($names as $i => $name) {
			$err = $is_multi ? ($file['error'][$i] ?? 4) : $file['error'];
			if ($err === UPLOAD_ERR_NO_FILE || empty($name))
				continue;
			if ($err !== UPLOAD_ERR_OK)
				continue;
			$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
			$tmp = $is_multi ? ($file['tmp_name'][$i] ?? '') : $file['tmp_name'];
			$size = $is_multi ? ($file['size'][$i] ?? 0) : $file['size'];
			if (!in_array($ext, $allowed) || $size > $max_size || empty($tmp) || !file_exists($tmp))
				continue;
			$finfo = @finfo_open(FILEINFO_MIME_TYPE);
			if ($finfo) {
				$mime = @finfo_file($finfo, $tmp);
				finfo_close($finfo);
				if ($mime && !in_array($mime, ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']))
					continue;
			}
			$new = uniqid('wcf_') . '_' . sanitize_file_name($name);
			$dest = $dir . '/' . $new;
			if (@move_uploaded_file($tmp, $dest))
				$uploaded[] = $dest;
		}
	}
	return $uploaded;
}

// ============================================================================
// 💾 7. БД
// ============================================================================
function wcf_save_to_db($form_id, $form_name, $data, $files = [])
{
	$display_name = $form_name ?: $form_id;
	$title = !empty($data['name']) ? 'Заявка от ' . $data['name'] . ' (' . $display_name . ')' : 'Заявка: ' . $display_name . ' #' . time();
	$post_id = wp_insert_post(['post_type' => 'wcf_submission', 'post_title' => wp_strip_all_tags($title), 'post_status' => 'publish', 'post_content' => '']);
	if ($post_id && !is_wp_error($post_id)) {
		add_post_meta($post_id, '_wcf_form_id', $form_id);
		add_post_meta($post_id, '_wcf_form_name', $form_name);
		add_post_meta($post_id, '_wcf_ip', $_SERVER['REMOTE_ADDR']);
		add_post_meta($post_id, '_wcf_time', current_time('timestamp'));
		foreach ($data as $k => $v)
			add_post_meta($post_id, '_wcf_' . sanitize_key($k), maybe_serialize($v));
		if (!empty($files))
			add_post_meta($post_id, '_wcf_files', maybe_serialize(array_map('basename', $files)));
	}
	return $post_id;
}

// ============================================================================
// 🔄 8. РЕДИРЕКТ (для старого admin_post_ обработчика)
// ============================================================================
function wcf_redirect($url, $data, $with_data, $form_id, $allowed_fields)
{
	if (empty($url))
		return false;
	$args = ['wcf_status' => 'ok', 'wcf_time' => time()];
	if ($form_id)
		$args['wcf_form'] = sanitize_key($form_id);
	if ($with_data) {
		$fields = !empty($allowed_fields) ? $allowed_fields : ['name', 'phone', 'email'];
		foreach ($fields as $f) {
			$f = sanitize_key(trim($f));
			if (!empty($f) && !empty($data[$f])) {
				$val = wp_strip_all_tags($data[$f]);
				$val = preg_replace('/[^\p{L}\p{N}\s\-\_\.\@\+\(\)]/u', '', $val);
				$args['wcf_' . $f] = rawurlencode($val);
			}
		}
	}
	wp_safe_redirect(add_query_arg($args, $url));
	exit;
}

// ============================================================================
// 🎯 9. ОБРАБОТЧИКИ
// ============================================================================

/**
 * Старый обработчик через admin-post.php — оставлен для совместимости.
 * Используется только если JS не загрузился (прогрессивное улучшение).
 */
add_action('admin_post_wcf_submit', 'wcf_frontend_handler');
add_action('admin_post_nopriv_wcf_submit', 'wcf_frontend_handler');

function wcf_frontend_handler()
{
	if ($_SERVER['REQUEST_METHOD'] !== 'POST')
		wp_die('Method not allowed', '', ['response' => 405]);
	$form_id = sanitize_key($_POST['form_id'] ?? '');
	if (empty($form_id))
		wp_die('Form ID required', '', ['response' => 400]);

	$exclude = ['form_id', '_wcf_nonce', '_wcf_hp', '_wp_http_referer', 'action'];
	$data = array_filter($_POST, fn($k) => !in_array($k, $exclude), ARRAY_FILTER_USE_KEY);
	$result = wcf_process_form($form_id, $data, $_FILES);

	$forms = get_option('wcf_forms', []);
	$config = $forms[$form_id] ?? [];

	if (!$result['success']) {
		$msg = $result['error'] ?? '⚠️ Ошибка отправки.';
		$back = wp_get_referer() ?: home_url();
		wp_die("<div style='max-width:500px;margin:50px auto;padding:25px;border:1px solid #ff4d4f;border-radius:8px;text-align:center;font-family:sans-serif;background:#fff2f0;'><h2 style='color:#cf1322;margin:0 0 10px;'>⚠️ Заявка не отправлена</h2><p style='margin:0 0 20px;'>{$msg}</p><a href='{$back}' style='display:inline-block;padding:10px 20px;background:#0073aa;color:#fff;text-decoration:none;border-radius:4px;'>← Вернуться и исправить</a></div>", '', ['response' => 400]);
	}
	if (empty($config['redirect_url'])) {
		$msg = '✅ Спасибо! Заявка отправлена.';
		$back = wp_get_referer() ?: home_url();
		wp_die("<div style='max-width:500px;margin:50px auto;padding:25px;border:1px solid #ddd;border-radius:8px;text-align:center;font-family:sans-serif;'><h2>✅ Готово!</h2><p>{$msg}</p><a href='{$back}' style='display:inline-block;padding:10px 20px;background:#0073aa;color:#fff;text-decoration:none;border-radius:4px;'>← На сайт</a></div>", '', ['response' => 200]);
	}
	$fields = array_map('trim', explode(',', $config['redirect_fields'] ?? 'name,phone,email'));
	wcf_redirect($config['redirect_url'], $data, !empty($config['redirect_with_data']), $form_id, $fields);
}

/**
 * ✨ НОВЫЙ AJAX-ОБРАБОТЧИК — используется JS на фронтенде.
 * Возвращает JSON: { success, message, redirect }
 */
add_action('wp_ajax_wcf_ajax_submit', 'wcf_ajax_handler');
add_action('wp_ajax_nopriv_wcf_ajax_submit', 'wcf_ajax_handler');

function wcf_ajax_handler()
{
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		wp_send_json_error(['message' => 'Method not allowed'], 405);
	}

	$form_id = sanitize_key($_POST['form_id'] ?? '');
	if (empty($form_id)) {
		wp_send_json_error(['message' => 'Form ID required'], 400);
	}

	$exclude = ['form_id', '_wcf_nonce', '_wcf_hp', '_wp_http_referer', 'action'];
	$data = array_filter($_POST, fn($k) => !in_array($k, $exclude), ARRAY_FILTER_USE_KEY);
	$result = wcf_process_form($form_id, $data, $_FILES);

	$forms = get_option('wcf_forms', []);
	$config = $forms[$form_id] ?? [];

	if (!$result['success']) {
		// Конкретная ошибка из process_form или общий текст из настроек формы
		$error_msg = $result['error'] ?? ($config['error_message'] ?? 'Ошибка отправки. Попробуйте позже.');
		wp_send_json_error(['message' => $error_msg]);
	}

	// Успех: возвращаем редирект или текст для вывода под формой
	$response = ['message' => $config['success_message'] ?? 'Спасибо! Ваша заявка принята.'];

	if (!empty($config['redirect_url'])) {
		// Строим URL редиректа
		$args = ['wcf_status' => 'ok', 'wcf_time' => time(), 'wcf_form' => $form_id];
		if (!empty($config['redirect_with_data'])) {
			$fields = array_map('trim', explode(',', $config['redirect_fields'] ?? 'name,phone,email'));
			foreach ($fields as $f) {
				$f = sanitize_key(trim($f));
				if (!empty($f) && !empty($data[$f])) {
					$val = preg_replace('/[^\p{L}\p{N}\s\-\_\.\@\+\(\)]/u', '', wp_strip_all_tags($data[$f]));
					$args['wcf_' . $f] = rawurlencode($val);
				}
			}
		}
		$response['redirect'] = add_query_arg($args, $config['redirect_url']);
	}

	wp_send_json_success($response);
}

/**
 * Ядро обработки: проверка + файлы + письма + TG + CRM + БД.
 * Используется обоими обработчиками.
 */
function wcf_process_form($form_id, $data, $files = [])
{
	$check = wcf_verify_submission($form_id);
	if (is_wp_error($check)) {
		wcf_log("Error [{$form_id}]: " . $check->get_error_message(), 'err');
		return ['success' => false, 'error' => $check->get_error_message()];
	}
	$forms = get_option('wcf_forms', []);
	if (!isset($forms[$form_id]))
		return ['success' => false, 'error' => 'Форма не настроена'];
	$config = $forms[$form_id];

	$clean = [];
	foreach ($data as $k => $v)
		$clean[sanitize_key($k)] = is_array($v) ? array_map('sanitize_textarea_field', $v) : sanitize_textarea_field($v);

	$uploaded = !empty($files) ? wcf_handle_files($files, $form_id, $config) : [];
	$files_attempted = false;
	foreach ($files as $f) {
		if (!empty($f['name']) && (is_array($f['name']) ? !empty($f['name'][0]) : $f['name'] !== '')) {
			$files_attempted = true;
			break;
		}
	}
	if ($files_attempted && empty($uploaded)) {
		$err_msg = 'Файл не принят. Разрешены: ' . $config['allowed_files'] . ' (до ' . ($config['max_file_size'] ?? 5) . ' МБ)';
		wcf_log($err_msg, 'warn');
		return ['success' => false, 'error' => $err_msg];
	}

	$form_name = $config['form_name'] ?? '';
	$labels = !empty($config['field_labels']) ? wcf_parse_field_labels($config['field_labels']) : [];
	$subject = wcf_parse_template($config['subject'] ?? 'Новая заявка', $clean, $form_id, $form_name, [], $labels);
	$body = wcf_parse_template($config['email_template'] ?? wcf_default_email_template(), $clean, $form_id, $form_name, $uploaded, $labels);

	wcf_send_email($config['emails'] ?? get_option('admin_email'), $subject, $body, $uploaded);
	if (!empty($config['telegram_enabled']) && !empty($config['telegram_token']))
		wcf_send_telegram($config['telegram_token'], $config['telegram_chat_id'], $clean, $form_id, $form_name, $uploaded, $labels);
	if (!empty($config['crm_enabled']))
		wcf_send_crm($clean, $config, $form_id, $form_name);
	if (!empty($config['save_to_db']))
		wcf_save_to_db($form_id, $form_name, $clean, $uploaded);

	do_action('wcf_form_processed', $form_id, $clean, $uploaded, $config);
	return ['success' => true, 'files_count' => count($uploaded)];
}

// ============================================================================
// 🎨 10. ШОРТКОД, ХЕЛПЕРЫ И ПОДКЛЮЧЕНИЕ СКРИПТОВ
// ============================================================================

/**
 * Подключаем скрипт и стили на фронтенде.
 * Передаём ajaxurl и настройки форм через wp_localize_script.
 */
add_action('wp_enqueue_scripts', 'wcf_enqueue_assets');
function wcf_enqueue_assets()
{
	// Собираем публичные данные форм (без токенов)
	$forms = get_option('wcf_forms', []);
	$public_forms = [];
	foreach ($forms as $id => $f) {
		$public_forms[$id] = [
			'allowed_files' => $f['allowed_files'] ?? WCF_DEFAULT_EXTENSIONS,
			'max_file_size' => $f['max_file_size'] ?? 5,
			'success_message' => $f['success_message'] ?? 'Спасибо! Ваша заявка принята.',
			'error_message' => $f['error_message'] ?? 'Ошибка отправки. Попробуйте позже.',
			'sending_text' => $f['sending_text'] ?? 'Отправка...',
		];
	}

	// Регистрируем пустой скрипт-якорь — JS встраивается инлайном.
	// Не зависит от plugin_dir_url / пути к файлу.
	wp_register_script('wcf-forms', '', [], '3.6', true);
	wp_enqueue_script('wcf-forms');

	// Переменная WCF (ajaxurl + данные форм) — до основного скрипта
	wp_add_inline_script(
		'wcf-forms',
		'var WCF = ' . wp_json_encode([
			'ajaxurl' => admin_url('admin-ajax.php'),
			'forms' => $public_forms,
		]) . ';',
		'before'
	);

	// Основной JS инлайном
	wp_add_inline_script('wcf-forms', wcf_get_inline_js());

	// Стили
	add_action('wp_head', function () {
		echo '<style id="wcf-styles">' . wcf_get_inline_styles() . '</style>';
	}, 5);
}

/**
 * Возвращает JS-код обработчика форм.
 * Встраивается инлайном — не требует отдельного файла.
 */
function wcf_get_inline_js()
{
	return <<<'JS'
(function () {
	'use strict';

	function getFormConfig(formId) {
		return (window.WCF && window.WCF.forms && window.WCF.forms[formId]) || {};
	}

	function showMessage(form, type, text) {
		var msg = form.nextElementSibling;
		if (!msg || !msg.classList.contains('wcf-message')) {
			msg = document.createElement('div');
			msg.className = 'wcf-message';
			form.parentNode.insertBefore(msg, form.nextSibling);
		}
		msg.className = 'wcf-message';
		requestAnimationFrame(function () {
			requestAnimationFrame(function () {
				msg.classList.add(type === 'success' ? 'wcf-success' : 'wcf-error');
				msg.textContent = text;
				msg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
			});
		});
	}

	function hideMessage(form) {
		var msg = form.nextElementSibling;
		if (msg && msg.classList.contains('wcf-message')) {
			msg.className = 'wcf-message';
		}
	}

	function lockForm(form, sendingText) {
		form.classList.add('wcf-form-loading');
		var btn = form.querySelector('[type="submit"]');
		var originalHTML = '';
		if (btn) {
			originalHTML = btn.innerHTML;
			btn.disabled = true;
			btn.innerHTML = '<span style="display:inline-flex;align-items:center;gap:8px;">'
				+ '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="animation:wcfSpin 1s linear infinite;flex-shrink:0;"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>'
				+ (sendingText || 'Отправка...')
				+ '</span>';
		}
		form.querySelectorAll('input, select, textarea').forEach(function (el) {
			el.dataset.wcfWasDisabled = el.disabled ? '1' : '0';
			el.disabled = true;
		});
		return { btn: btn, originalHTML: originalHTML };
	}

	function unlockForm(form, lockState) {
		form.classList.remove('wcf-form-loading');
		if (lockState.btn) {
			lockState.btn.disabled = false;
			lockState.btn.innerHTML = lockState.originalHTML;
		}
		form.querySelectorAll('input, select, textarea').forEach(function (el) {
			if (el.dataset.wcfWasDisabled === '0') el.disabled = false;
			delete el.dataset.wcfWasDisabled;
		});
	}

	function validateFiles(form, config) {
		var fileInputs = form.querySelectorAll('input[type="file"]');
		if (!fileInputs.length) return null;
		var allowed = (config.allowed_files || 'jpg,jpeg,png,pdf,doc,docx')
			.split(',').map(function (s) { return s.trim().toLowerCase(); });
		var maxMb    = parseFloat(config.max_file_size) || 5;
		var maxBytes = maxMb * 1024 * 1024;
		for (var i = 0; i < fileInputs.length; i++) {
			var input = fileInputs[i];
			if (!input.files || !input.files.length) continue;
			for (var j = 0; j < input.files.length; j++) {
				var file = input.files[j];
				var ext  = file.name.split('.').pop().toLowerCase();
				if (!allowed.includes(ext)) {
					return 'Формат «' + ext + '» не поддерживается. Разрешены: ' + allowed.join(', ');
				}
				if (file.size > maxBytes) {
					return 'Файл «' + file.name + '» слишком большой. Максимум: ' + maxMb + ' МБ';
				}
			}
		}
		return null;
	}

	function submitForm(form) {
		var formId = form.dataset.formId
			|| (form.querySelector('[name="form_id"]') || {}).value
			|| '';
		var config      = getFormConfig(formId);
		var ajaxUrl     = (window.WCF && window.WCF.ajaxurl) || '/wp-admin/admin-ajax.php';
		var sendingText = config.sending_text || 'Отправка...';

		hideMessage(form);

		var fileError = validateFiles(form, config);
		if (fileError) {
			showMessage(form, 'error', '⚠️ ' + fileError);
			return;
		}

		// FormData собираем ДО блокировки — задизейбленные поля не попадают в FormData
		var formData  = new FormData(form);
		formData.set('action', 'wcf_ajax_submit');

		var lockState = lockForm(form, sendingText);

		fetch(ajaxUrl, {
			method:      'POST',
			body:        formData,
			credentials: 'same-origin',
		})
		.then(function (response) {
			if (!response.ok) throw new Error('HTTP ' + response.status);
			return response.json();
		})
		.then(function (data) {
			unlockForm(form, lockState);
			if (data.success) {
				if (data.data && data.data.redirect) {
					window.location.href = data.data.redirect;
					return;
				}
				var successText = (data.data && data.data.message)
					|| config.success_message
					|| '✅ Спасибо! Ваша заявка принята.';
				showMessage(form, 'success', successText);
				form.reset();
			} else {
				var errorText = (data.data && data.data.message)
					|| config.error_message
					|| '⚠️ Ошибка отправки. Попробуйте ещё раз.';
				showMessage(form, 'error', '⚠️ ' + errorText);
			}
		})
		.catch(function (err) {
			unlockForm(form, lockState);
			showMessage(form, 'error', '⚠️ ' + (config.error_message || 'Сетевая ошибка. Проверьте соединение.'));
			console.error('[WCF]', err);
		});
	}

	document.addEventListener('submit', function (e) {
		var form = e.target;
		if (!form.classList.contains('wcf-form')) return;
		e.preventDefault();
		submitForm(form);
	}, false);

})();
JS;
}

function wcf_get_inline_styles()
{
	return '
.wcf-message {
	display: none;
	margin-top: 16px;
	padding: 14px 18px;
	border-radius: 6px;
	font-size: 15px;
	line-height: 1.5;
	animation: wcfFadeIn .3s ease;
}
.wcf-message.wcf-success {
	display: block;
	background: #f0fdf4;
	border: 1px solid #86efac;
	color: #166534;
}
.wcf-message.wcf-error {
	display: block;
	background: #fff2f0;
	border: 1px solid #fca5a5;
	color: #991b1b;
}
@keyframes wcfFadeIn {
	from { opacity: 0; transform: translateY(-6px); }
	to   { opacity: 1; transform: translateY(0); }
}
.wcf-form-loading {
	pointer-events: none;
	opacity: .7;
}
	';
}

/**
 * Шорткод [wcf_form id="my_form_id"]
 * Рендерит обёртку формы с нужными скрытыми полями.
 * Поля добавляются через хук wcf_form_fields_{id}.
 */
add_shortcode('wcf_form', 'wcf_shortcode_form');
function wcf_shortcode_form($atts)
{
	$id = sanitize_key($atts['id'] ?? 'default');
	$forms = get_option('wcf_forms', []);
	if (!isset($forms[$id]))
		return '<p style="color:red;">⚠️ Форма "' . esc_html($id) . '" не настроена.</p>';

	ob_start(); ?>
	<form method="post" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"
		class="wcf-form" data-form-id="<?php echo esc_attr($id); ?>">
		<?php wcf_form_nonce_field($id); ?>
		<input type="hidden" name="form_id" value="<?php echo esc_attr($id); ?>">
		<input type="hidden" name="action" value="wcf_submit">
		<?php do_action('wcf_form_fields_' . $id); ?>
	</form>
	<?php return ob_get_clean();
}

/**
 * wcf_form_fields( $form_id ) — хелпер для произвольных форм в шаблоне.
 *
 * Использование:
 *   <form method="post" enctype="multipart/form-data" class="wcf-form" data-form-id="my_form_id">
 *     <?php wcf_form_fields('my_form_id'); ?>
 *     <!-- ваши поля -->
 *     <button type="submit">Отправить</button>
 *   </form>
 *
 * Требования к форме:
 *   1. class="wcf-form"
 *   2. data-form-id="your_form_id"
 *   3. enctype="multipart/form-data" (если есть файлы)
 */
function wcf_form_fields($form_id)
{
	echo '<input type="hidden" name="form_id" value="' . esc_attr($form_id) . '">';
	echo '<input type="hidden" name="action"  value="wcf_submit">';
	wcf_form_nonce_field($form_id);
}

function wcf_is_success()
{
	return isset($_GET['wcf_status']) && $_GET['wcf_status'] === 'ok';
}

// ============================================================================
// 🧹 ЛОГИ & ОЧИСТКА
// ============================================================================
function wcf_log($msg, $level = 'info')
{
	if (!defined('WCF_DEBUG') || !WCF_DEBUG)
		return;
	error_log(sprintf("[%s] [%s] %s - %s\n", current_time('mysql'), strtoupper($level), $_SERVER['REMOTE_ADDR'] ?? 'CLI', $msg), 3, WP_CONTENT_DIR . '/wcf-debug.log');
}
function wcf_cleanup_submissions($days = 90)
{
	$ids = get_posts(['post_type' => 'wcf_submission', 'fields' => 'ids', 'date_query' => [['before' => date('Y-m-d', strtotime("-{$days} days"))]], 'posts_per_page' => -1]);
	foreach ($ids as $id)
		wp_delete_post($id, true);
}