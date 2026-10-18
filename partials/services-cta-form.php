<?php
$page = 'options';

$title = get_field('section_form_cta_title', $page) ?? '';
$bg = get_template_directory_uri() . '/assets/images/decor/cta-decor.png';
$vb = get_template_directory_uri() . '/assets/images/icons/vb.svg';
?>
<section class="section cta-form services-cta-form" id="services-cta-form"
	style="--decor-bg: url('<?php echo esc_url($bg) ?>'); --vb: url('<?php echo esc_url($vb) ?>');">
	<div class="container cta-form__container">
		<div class="services-cta-form__wrapper">
			<h2 class="cta-form__title title-2 title-mix mb-title">
				Напишите ваше имя и номер телефона и мы вышлем коммерческое предложение
			</h2>
			<div class="cta-form__form">
				<?php echo do_shortcode('[contact-form-7 id="2fc08f6" title="Оставьте заявку"]'); ?>
			</div>
		</div>
	</div>
</section>