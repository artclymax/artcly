<?php
$title = get_field('single_services_for_whom_title') ?? '';
$descr = get_field('single_services_for_whom_descr') ?? '';
$image = get_field('single_services_for_whom_image') ?? '';
$image_effects = get_field('single_services_for_whom_image_effects') ?? '';

?>
<?php if ($descr): ?>
	<section class="section services-for-whom" id="services-for-whom">
		<div class="container services-for-whom__container">
			<div class="services-for-whom__content">
				<h2 class="services-for-whom__title title-1 title-mix descr">
					<?php echo wp_kses_post($title) ?>
				</h2>
				<div class="services-for-whom__descr descr">
					<?php echo wp_kses_post($descr) ?>
				</div>
			</div>
			<div class="services-for-whom__image image-box <?= $image_effects ? 'image-effects' : '' ?>" aria-hidden="true">
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