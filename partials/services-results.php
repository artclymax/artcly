<?php
$title = get_field('services_results_title') ?? '';
$list = get_field('services_results_list') ?? '';
$image = get_field('services_results_image') ?? '';
$note = get_field('services_results_note') ?? '';

?>
<?php if ($list): ?>
	<section class="section services-results" id="services-results">
		<div class="container services-results__container">
			<h2 class="services-results__title title-1 title-mix descr">
				<?php echo wp_kses_post($title) ?>
			</h2>
			<div class="services-results__wrapper">
				<div class="services-results__content">
					<div class="services-results__list">
						<?php echo wp_kses_post($list) ?>
					</div>
					<div class="services-results__note descr">
						<?php echo wp_kses_post($note)?>
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
	</section>
<?php endif; ?>