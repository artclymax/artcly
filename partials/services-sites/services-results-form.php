<?php
$title = get_field('services_results_form_title') ?? '';
$list = get_field('services_results_form_list') ?? '';
$image = get_field('services_results_form_image') ?? '';

$form_title= get_field('services_results_form_title_form') ?? '';
$form = get_field('services_results_form_form') ?? '';
$bg = get_template_directory_uri() . '/assets/images/decor/cta-decor.png';
$vb = get_template_directory_uri() . '/assets/images/icons/vb.svg';
?>
<?php if ($list): ?>
	<section class="section services-results services-results-form" id="services-results">
		<div class="container services-results__container">
			<h2 class="services-results__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<div class="services-results__wrapper">
				<div class="services-results__content">
					<div class="services-results__list">
						<?php echo wp_kses_post($list) ?>
					</div>
				</div>
				<div class="services-for-whom__image image-box image-effects services-results__image" aria-hidden="true">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'large',
						false,
						array(
							'class' => 'img',
							'alt' => $image['alt'] ?: ''
						)
					); ?>
				</div>
			</div>
		</div>
		<div class="services-results__form section cta-form services-cta-form services-cta-form-second"
			style="--decor-bg: url('<?php echo esc_url($bg) ?>'); --vb: url('<?php echo esc_url($vb) ?>');">
			<div class="container cta-form__container">
				<div class="services-cta-form__wrapper">
					<h2 class="cta-form__title title-2 title-mix descr">
						<?php echo wp_kses_post($form_title) ?>
					</h2>
					<div class="cta-form__form">
						<?php echo do_shortcode($form); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>