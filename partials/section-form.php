<?php
$page = 'options';

$title = get_field('section_form_title', $page) ?? '';
$descr = get_field('section_form_descr', $page) ?? '';
$bg = get_template_directory_uri() . '/assets/images/decor/decor-form.png';
$vb = get_template_directory_uri() . '/assets/images/icons/vb.svg';
?>
<section class="section section-form" id="section-form"
	style="--decor-bg: url('<?php echo esc_url($bg) ?>'); --vb: url('<?php echo esc_url($vb) ?>');">
	<div class="container section-form__container">
		<div class="section-form__body">
			<div class="section-form__content">
				<h2 class="section-form__title title-2 title-mix descr">
					<?php echo wp_kses_post($title) ?>
				</h2>
				<div class="section-form__descr descr">
					<?php echo wp_kses_post($descr) ?>
				</div>
			</div>
			<div class="section-form__form">
				<h3 class="section-form__subtitle title-3">Заполните форму</h3>
				<!--<?php echo do_shortcode('[contact-form-7 id="2fc08f6" title="Оставьте заявку"]'); ?>-->
				<?php echo mx_form() ?>
			</div>
		</div>
	</div>
</section>