<?php
$page = 'options';

$title = get_field('thank_you_title', $page) ?? '';
$descr = get_field('thank_you_descr', $page) ?? '';
$btn_home = get_field('thank_you_btn_home', $page) ?? '';
$btn_form = get_field('thank_you_btn_form', $page) ?? '';
$image = get_field('thank_you_image', $page) ?? '';
$vb = get_template_directory_uri() . '/assets/images/icons/vb.svg';
$phone = $_GET['wcf_msg_phone'] ?? '';
$viber = $_GET['wcf_msg_viber'] ?? '';
$whatsapp = $_GET['wcf_msg_whatsapp'] ?? '';
$telegram = $_GET['wcf_msg_telegram'] ?? '';
?>
<section class="hero-thank-you jarallax" id="hero-thank-you"
	style="background-image: url(<?php echo esc_url($image['url']) ?>);--vb: url('<?php echo esc_url($vb) ?>');">
	<div class="container hero-thank-you__container">
		<div class="hero-thank-you__body">
			<h2 class="hero-thank-you__title title-first descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<div class="hero-thank-you__descr descr title-3">
				<?php echo wp_kses_post($descr) ?>
			</div>
			<div class="hero-thank-you__form">
				<h3 class="hero-thank-you__form-title title-2">
					Проверьте правильность введенных данных:
				</h3>
				<div class="hero-thank-you__form-item text-2">
					<span class="hero-thank-you__form-key gradient-text">
						Телефон:
					</span>
					<span class="hero-thank-you__form-value"><?php echo $_GET['wcf_phone']; ?></span>
				</div>
				<div class="hero-thank-you__form-item text-2">
					<span class="hero-thank-you__form-key gradient-text">
						Способ связи:
					</span>
					<ul class="hero-thank-you__form-value-list">
						<?php if ($phone) {
							echo '<li><img src="' . get_template_directory_uri() . '/assets/images/icons/phone-icon.svg' . '" alt="Телефон" title="Телефон"></li>';
						}
						if ($viber) {
							echo '<li><img src="' . get_template_directory_uri() . '/assets/images/icons/vb.svg' . '" alt="Вайбер" title="Вайбер"></li>';
						}
						if ($whatsapp) {
							echo '<li><img src="' . get_template_directory_uri() . '/assets/images/icons/wh.svg' . '" alt="Ватсап" title="Ватсап"></li>';
						}
						if ($telegram) {
							echo '<li><img src="' . get_template_directory_uri() . '/assets/images/icons/tg.svg' . '" alt="Телеграм" title="Телеграм"></li>';
						} ?>
					</ul>
				</div>
				<small class="hero-thank-you__form-small">
					Если вы обнаружили ошибку, пожалуйста, вернитесь и заполните форму снова.
				</small>
			</div>
			<div class="hero-thank-you__btn-box">
				<a class="btn hero-thank-you__btn" href="	<?php echo esc_attr($btn_home['url']) ?>">
					<?php echo esc_html($btn_home['title']) ?>
				</a>
				<a class="btn btn--stroke hero-thank-you__btn" href="	<?php echo esc_attr($btn_form['url']) ?>">
					<?php echo esc_html($btn_form['title']) ?>
				</a>
			</div>
		</div>
	</div>
</section>