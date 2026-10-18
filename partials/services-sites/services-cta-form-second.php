<?php
$title = get_field('section_form_second_cta_title') ?? '';
$form = get_field('section_form_second_cta_form') ?? '';
$bg = get_template_directory_uri() . '/assets/images/decor/cta-decor.png';
$vb = get_template_directory_uri() . '/assets/images/icons/vb.svg';
?>
<?php if ($form): ?>
	<section class="section cta-form services-cta-form services-cta-form-second" id="services-cta-form"
		style="--decor-bg: url('<?php echo esc_url($bg) ?>'); --vb: url('<?php echo esc_url($vb) ?>');">
		<div class="container cta-form__container">
			<div class="services-cta-form__wrapper">
				<h2 class="cta-form__title title-2 title-mix descr">
					<?php echo wp_kses_post($title) ?>
				</h2>
				<div class="cta-form__form">
					<?php echo do_shortcode($form); ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>